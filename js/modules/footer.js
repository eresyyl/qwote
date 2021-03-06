/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $) {
  'use strict';
  var $body = $('body');

  $.modules.register("footer", {
    opened: false,
    togglename: '.footer-arrow',
    instanceflag: 'is-open',
    bodyflag: 'site-footer-open',
    init: function() {
      this.$instance = $('.footer');

      if (this.$instance.length === 0) {
        return;
      }

      this.bind();
    },

    bind: function() {
      var self = this;
      $(document).on('click', this.togglename, function() {
        self.opened ? self.close() : self.open();
        self.opened = !self.opened;
      });
    },

    open: function() {
      this.$instance.addClass(this.instanceflag);
      $body.addClass(this.bodyflag);
    },

    close: function() {
      this.$instance.removeClass(this.instanceflag);
      $body.removeClass(this.bodyflag);
    }

  });

})(window, document, jQuery);
