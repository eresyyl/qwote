/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("breadcrumb", {
  mode: "init",
  defaults: {
    namespace: "breadcrumb"
  },
  init: function(context) {
    if (!$.fn.asPieProgress) return;
    var defaults = $.components.getDefaults("breadcrumb");

    $('[data-plugin="breadcrumb"]', context).each(function() {
      var options = $.extend({}, defaults, $(this).data());

      $(this).asBreadcrumbs(options);
    });
  }
});
