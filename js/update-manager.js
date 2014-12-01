/**
 * Instantiate update manager
 *
 * @param checkUrl
 * @param fetchUrl
 * @param container
 * @param append
 * @param position
 * @constructor
 */
function UpdateManager(checkUrl, fetchUrl, container, append, position) {
    this.checkUrl = checkUrl;
    this.fetchUrl = fetchUrl;
    this.container = container;
    this.append = append;
    this.position = position;
}

/**
 * @param url
 */
UpdateManager.prototype.setCheckUrl = function (url) {
    this.checkUrl = url;
}

/**
 * @param url
 */
UpdateManager.prototype.fetchUrl = function (url) {
    this.fetchUrl = url;
}

/**
 * @param container
 */
UpdateManager.prototype.setContainer = function (container) {
    this.container = container;
}

/**
 * @param append
 */
UpdateManager.prototype.setAppend = function (append) {
    this.append = append;
}

/**
 * @param step
 */
UpdateManager.prototype.start = function (step) {
    var self = this;
    self.step = (step === undefined) ? 5000 : step;

    self.thread = setInterval(function () {
        $.ajax({
            url: self.checkUrl,
            success: function (data) {
                if (self.lastData === undefined) {
                    self.lastData = data;
                    return;
                }

                if (!_.isEqual(self.lastData, data)) {
                    $.ajax({
                        url: self.fetchUrl,
                        success: function (data) {
                            if (data.update !== undefined && $(self.container).length > 0) {
                                if (self.append) {
                                    if (typeof UPDATEMANAGER_POSITION_END === 'undefined' || this.position == UPDATEMANAGER_POSITION_END) {
                                        $(self.container).append(data.update);
                                    } else {
                                        $(self.container).prepend(data.update);
                                    }
                                } else {
                                    $(self.container).html(data.update);
                                }

                                if (data.success !== undefined && data.success.length > 0) {
                                    $(self.container)
                                        .append('<div class="bg-primary update-success">' + data.success + '</div>')
                                        .find(".update-success")
                                        .fadeIn(1000, function () {
                                            var self = this;
                                            setTimeout(function () {
                                                $(self).fadeOut();
                                            }, 9000);
                                        });
                                }

                                delete self.data;
                            }
                        }
                    })
                }

                self.lastData = data;
            }
        })
    }, self.step);
}

UpdateManager.prototype.stop = function () {
    clearInterval(this.thread);
}