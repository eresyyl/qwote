/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("panel", {
  mode: "init",
  init: function() {

    $(document).on('click.site.panel', '[data-toggle="full"]', function(e) {
      e.preventDefault();
      var $this = $(this),
        $panel = $this.closest('.panel');
      $panel.toggleClass('is-fullscreen');

      if ($this.hasClass('wb-expand')) {
        $this.removeClass('wb-expand').addClass('wb-contract');

      } else if ($this.hasClass('wb-contract')) {
        $this.removeClass('wb-contract').addClass('wb-expand');
      }
    });

    $(document).on('click.site.panel', '[data-toggle="collapse"]', function(e) {
      e.preventDefault();
      var $this = $(this);

      if ($this.hasClass('wb-minus')) {
        $this.removeClass('wb-minus').addClass('wb-plus');

      } else if ($this.hasClass('wb-plus')) {
        $this.removeClass('wb-plus').addClass('wb-minus');
      }
    });

    $(document).on('click.site.panel', '[data-toggle="close"]', function(e) {
      e.preventDefault();
      var $this = $(this),
        $panel = $this.closest('.panel');

      $panel.hide();
      $panel.trigger('uikit.panel.close');
    });

    $(document).on('click.site.panel', '[data-toggle="refresh"]', function(e) {
      e.preventDefault();
      var $this = $(this);
      var $panel = $this.closest('.panel');
      var type = $this.data('loader-type');
      if (!type) {
        type = 'default';
      }
      var $loading = $('<div class="panel-loading">' +
        '<div class="loader loader-' + type + '"></div>' +
        '</div>');

      $loading.appendTo($panel);

      $panel.addClass('is-loading');

      $panel.trigger('uikit.panel.loading');

      var done = function() {
        $loading.remove();
        $panel.removeClass('is-loading');
        $panel.trigger('uikit.panel.loading.done');
      }

      var callback = $this.data('loaderCallback');

      if ($.isFunction(window[callback])) {
        window[callback].call($panel[0], done);
      }
    });
  }
});
