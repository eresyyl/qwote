/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $) {
  'use strict';

  $.modules.register("aside", {
    opened: false,
    toggle: '.site-aside-switch',
    instanceflag: 'is-open',

    init: function() {
      this.$instance = $('.site-aside');

      if (this.$instance.length === 0) {
        return;
      }

      this.bind();
    },
    bind: function() {
      var self = this;

      $(document).on('click', this.toggle, function() {
        self.opened ? self.close() : self.open();
        self.opened = !self.opened;
      });
    },

    open: function() {
      this.$instance.addClass(this.instanceflag);
    },

    close: function() {
      this.$instance.removeClass(this.instanceflag);
    }
  });
})(window, document, jQuery);
