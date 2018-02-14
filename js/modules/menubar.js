/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $) {
  'use strict';
  var $body = $('body');

  $.modules.register("menubar", {
    opened: null,
    $instance: null,
    init: function() {
      this.$instance = $(".site-menubar");
      if (this.$instance.length === 0) {
        return;
      }

      var self = this;

      this.$instance.on('changing.modules.menubar', function() {
        $('[data-toggle="site-menubar"]').each(function() {
          var $this = $(this);
          var $hamburger = $(this).find('.hamburger');

          function toggle($el) {
            $el.toggleClass('hided', !self.opened);
          }
          if ($hamburger.length > 0) {
            toggle($hamburger);
          } else {
            toggle($this);
          }
        });
      });

      $(document).on('click', '[data-toggle="site-menubar"]', function() {
        self.toggle();
        return false;
      });

      this.$instance.on('changed.modules.menubar', function() {
        self.update();
      });

      this.change();

      Breakpoints.on('change', function() {
        self.change();
      });
    },

    change: function() {
      var breakpoint = Breakpoints.current();
      this.reset();

      if (breakpoint.name == 'sm') {
        this.hide();
      }
    },

    animate: function(doing, callback) {
      var self = this;
      // $body.addClass('site-menubar-changing');

      doing.call(self);
      this.$instance.trigger('changing.modules.menubar');

      setTimeout(function() {
        if (callback) {
          callback.call(self);
        }
        // $body.removeClass('site-menubar-changing');

        self.$instance.trigger('changed.modules.menubar');
      }, 500);
    },

    reset: function() {
      this.opened = null;
      this.folded = null;
      $body.removeClass('site-menubar-hide site-menubar-open');
    },

    open: function() {
      if (this.opened !== true) {
        this.animate(function() {
          var $page = $('.site-body, .site-hero'),
            $footer = $('.footer');

          this.$instance.animate({
            left: 0
          }, 300);
          $page.animate({
            left: '260px'
          }, 300);
          $footer.animate({
            left: '260px'
          }, 300);
          if ($.modules._sections.footer.opened) {
            $('.footer-detial').animate({
              left: '260px'
            }, 300);
          }

          $body.removeClass('site-menubar-hide').addClass('site-menubar-open');
          this.opened = true;

        }, function() {
          this.scrollable.enable();
        });
      }
    },

    hide: function() {
      if (this.opened !== false) {
        this.animate(function() {
          var $page = $('.site-body, .site-hero'),
            $footer = $('.footer');

          this.$instance.animate({
            left: '-260px'
          }, 300);
          $page.animate({
            left: 0
          }, 300);
          $footer.animate({
            left: 0
          }, 300);
          if ($.modules._sections.footer.opened) {
            $('.footer-detial').animate({
              left: 0
            }, 300);
          }

          $body.removeClass('site-menubar-open').addClass('site-menubar-hide');
          this.opened = false;

        }, function() {
          this.scrollable.enable();
        });
      }
    },

    toggle: function() {
      var breakpoint = Breakpoints.current();
      var opened = this.opened;

      if (breakpoint.name === 'xs') {
        if (opened === null || opened === false) {
          this.open();
        } else {
          this.hide();
        }
      }
    },

    update: function() {
      this.scrollable.update();
      // this.hoverscroll.update();
    },

    scrollable: {
      api: null,
      init: function() {
        this.api = $.modules._sections.menubar.$instance.asScrollable({
          namespace: 'scrollable',
          skin: 'scrollable-inverse',
          direction: 'vertical',
          contentSelector: '>',
          containerSelector: '>'
        }).data('asScrollable');
      },

      update: function() {
        if (this.api) {
          this.api.update();
        }
      },

      enable: function() {
        if (!this.api) {
          this.init();
        }
        if (this.api) {
          this.api.enable();
        }
      },

      disable: function() {
        if (this.api) {
          this.api.disable();
        }
      }
    }
  });
})(window, document, jQuery);
