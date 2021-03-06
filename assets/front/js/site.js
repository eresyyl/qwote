/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $) {
  'use strict';

  // var $win = $(window),
  //   $doc = $(document),
  //   $body = $(document.body);

  // configs setup
  // =============
  $.configs.set('site', {
    fontFamily: "Noto Sans, sans-serif",
    primaryColor: "blue"
  });

  window.Site = $.site.extend({
    run: function(next) {
      // Init Loaded Components
      // ======================
      $.components.init();

      // Init Loaded Sections
      // ======================
      $.modules.init();

      next();
    }
  });

  // Sections
  // ==========
  $.modules = $.modules || {};

  $.extend($.modules, {
    _sections: {},
    register: function(name, obj) {

      this._sections[name] = obj;
    },
    init: function(name, context, args) {
      var self = this;

      if (typeof name === 'undefined') {
        $.each(this._sections, function(name) {
          self.init(name);
        });
      } else {
        context = context || document;
        args = args || [];

        var obj = this._sections[name];
        obj.init();
      }
    }
  });

})(window, document, jQuery);
