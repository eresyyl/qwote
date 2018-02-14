/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $) {
  'use strict';

  $.modules.register("menu", {
    speed: 250,
    accordion: true, // A setting that changes the collapsible behavior to expandable instead of the default accordion style

    init: function() {
      this.$instance = $('.site-menu');
      if (this.$instance.length === 0) {
        return;
      }
      this.bind();
    },
    bind: function() {
      var self = this;

      this.$instance.on('active.modules.menu', '.site-menu-item', function(e) {
        var $item = $(this);

        $item.addClass('active');
        e.stopPropagation();
      }).on('deactive.modules.menu', '.site-menu-item.active', function(e) {
        var $item = $(this);

        $item.removeClass('active');
        e.stopPropagation();
      }).on('open.modules.menu', '.site-menu-item', function(e) {
        var $item = $(this);

        self.expand($item, function() {
          $item.addClass('open');
        });

        if (self.accordion) {
          $item.siblings('.open').trigger('close.modules.menu');
        }

        e.stopPropagation();
      }).on('close.modules.menu', '.site-menu-item.open', function(e) {
        var $item = $(this);

        self.collapse($item, function() {
          $item.removeClass('open');
        });

        e.stopPropagation();
      }).on('click.modules.menu', '.site-menu-item', function(e) {
        var $this = $(this);
        if ($this.is('.has-sub')) {
          e.preventDefault();

          if ($this.is('.open')) {
            $this.trigger('close.modules.menu');
          } else {
            $this.trigger('open.modules.menu');
          }
        } else {
          if (!$this.is('.active')) {
            $this.siblings('.active').trigger('deactive.modules.menu');
            $this.trigger('active.modules.menu');
          }
        }

        e.stopPropagation();
      });
    },
    collapse: function($item, callback) {
      var self = this;
      var $sub = $item.children('.site-menu-sub');

      $sub.show().slideUp(this.speed, function() {
        $(this).css('display', '');

        $(this).find('> .site-menu-item').removeClass('is-shown');

        if (callback) {
          callback();
        }

        self.$instance.trigger('collapsed.frontend.menu');
      });
    },
    expand: function($item, callback) {
      var self = this;
      var $sub = $item.children('.site-menu-sub');
      var $children = $sub.children('.site-menu-item').addClass('is-hidden');

      $sub.hide().slideDown(this.speed, function() {
        $(this).css('display', '');

        if (callback) {
          callback();
        }

        self.$instance.trigger('expanded.modules.menu');
      });

      setTimeout(function() {
        $children.addClass('is-shown');
        $children.removeClass('is-hidden');
      }, 0);
    }
  });
})(window, document, jQuery);
