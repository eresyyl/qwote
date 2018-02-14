/*!
 * remark-frontend v1.0.0 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("animate-list", {
  mode: 'init',

  defaults: {
    child: '.panel',
    duration: 250,
    delay: 50,
    animate: 'scale-up',
    fill: 'backwards'
  },

  init: function() {
    var self = this;

    $('[data-plugin=animateList]').each(function() {
      var $this = $(this),
        options = $.extend({}, self.defaults, $this.data(), true);


      var animatedBox = function($el, opts) {
        this.options = opts;
        this.$children = $el.find(opts.child);
        this.$children.addClass('animation-' + opts.animate);
        this.$children.css('animation-fill-mode', opts.fill);
        this.$children.css('animation-duration', opts.duration + 'ms');

        var delay = 0,
          self = this;

        this.$children.each(function() {

          $(this).css('animation-delay', delay + 'ms');
          delay += self.options.delay;
        });
      };

      animatedBox.prototype = {
        run: function(type) {
          var self = this;
          this.$children.removeClass('animation-' + this.options.animate);
          if (typeof type !== 'undefined') this.options.animate = type;
          setTimeout(function() {
            self.$children.addClass('animation-' + self.options.animate);
          }, 0);
        }
      };

      $this.data('animateList', new animatedBox($this, options));
    });
  }
});

$.components.register("animsition", {
  mode: "manual",
  defaults: {
    inClass: 'fade-in',
    outClass: 'fade-out',
    inDuration: 1500,
    outDuration: 800,
    linkElement: '.animsition-link',
    loading: true,
    loadingParentElement: "body",
    loadingClass: "loader",
    loadingType: "default",
    unSupportCss: ['animation-duration',
      '-webkit-animation-duration',
      '-o-animation-duration'
    ],
    overlay: false,
    // random: true,
    overlayClass: 'animsition-overlay-slide',
    overlayParentElement: "body",

    inDefaults: [
      'fade-in',
      'fade-in-up-sm', 'fade-in-up', 'fade-in-up-lg',
      'fade-in-down-sm', 'fade-in-down', 'fade-in-down-lg',
      'fade-in-left-sm', 'fade-in-left', 'fade-in-left-lg',
      'fade-in-right-sm', 'fade-in-right', 'fade-in-right-lg',
      // 'overlay-slide-in-top', 'overlay-slide-in-bottom', 'overlay-slide-in-left', 'overlay-slide-in-right',
      'zoom-in-sm', 'zoom-in', 'zoom-in-lg'
    ],
    outDefaults: [
      'fade-out',
      'fade-out-up-sm', 'fade-out-up', 'fade-out-up-lg',
      'fade-out-down-sm', 'fade-out-down', 'fade-out-down-lg',
      'fade-out-left-sm', 'fade-out-left', 'fade-out-left-lg',
      'fade-out-right-sm', 'fade-out-right', 'fade-out-right-lg',
      // 'overlay-slide-out-top', 'overlay-slide-out-bottom', 'overlay-slide-out-left', 'overlay-slide-out-right'
      'zoom-out-sm', 'zoom-out', 'zoom-out-lg'
    ]
  },
  init: function(context, callback) {

    var options = $.components.getDefaults("animsition");

    if (options.random) {
      var li = options.inDefaults.length,
        lo = options.outDefaults.length;

      var ni = parseInt(li * Math.random()),
        no = parseInt(lo * Math.random());

      options.inClass = options.inDefaults[ni];
      options.outClass = options.outDefaults[no];
    }

    var $this = $(".animsition", context);

    $this.animsition(options);

    $("." + options.loadingClass).addClass('loader-' + options.loadingType);

    if ($this.animsition('supportCheck', options)) {
      if ($.isFunction(callback)) {
        $this.one('animsition.end', function() {
          callback.call();
        });
      }

      return true;
    } else {
      if ($.isFunction(callback)) {
        callback.call();
      }
      return false;
    }
  }
});

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

$.components.register("paginator", {
  mode: "init",
  defaults: {
    namespace: "pagination",
    currentPage: 1,
    itemsPerPage: 10,
    disabledClass: "disabled",
    activeClass: "active",

    visibleNum: {
      0: 3,
      480: 5
    },

    tpl: function() {
      return '{{prev}}{{lists}}{{next}}';
    },

    components: {
      prev: {
        tpl: function() {
          return '<li class="' + this.namespace + '-prev"><a href="javascript:void(0)"><span class="icon wb-chevron-left-mini"></span></a></li>';
        }
      },
      next: {
        tpl: function() {
          return '<li class="' + this.namespace + '-next"><a href="javascript:void(0)"><span class="icon wb-chevron-right-mini"></span></a></li>';
        }
      },
      lists: {
        tpl: function() {
          var lists = '',
            remainder = this.currentPage >= this.visible ? this.currentPage % this.visible : this.currentPage;
          remainder = remainder === 0 ? this.visible : remainder;
          for (var k = 1; k < remainder; k++) {
            lists += '<li class="' + this.namespace + '-items" data-value="' + (this.currentPage - remainder + k) + '"><a href="javascript:void(0)">' + (this.currentPage - remainder + k) + '</a></li>';
          }
          lists += '<li class="' + this.namespace + '-items ' + this.classes.active + '" data-value="' + this.currentPage + '"><a href="javascript:void(0)">' + this.currentPage + '</a></li>';
          for (var i = this.currentPage + 1, limit = i + this.visible - remainder - 1 > this.totalPages ? this.totalPages : i + this.visible - remainder - 1; i <= limit; i++) {
            lists += '<li class="' + this.namespace + '-items" data-value="' + i + '"><a href="javascript:void(0)">' + i + '</a></li>';
          }

          return lists;
        }
      }
    }
  },
  init: function(context) {
    if (!$.fn.asPaginator) return;

    var defaults = $.components.getDefaults("paginator");

    $('[data-plugin="paginator"]', context).each(function() {
      var $this = $(this),
        options = $this.data();

      var total = $this.data("total");

      options = $.extend({}, defaults, options);
      $this.asPaginator(total, options);
    });
  }
});

$.components.register("pieProgress", {
  mode: "init",
  defaults: {
    namespace: "pie-progress",
    speed: 30,
    classes: {
      svg: "pie-progress-svg",
      element: "pie-progress",
      number: "pie-progress-number",
      content: "pie-progress-content"
    }
  },
  init: function(context) {
    if (!$.fn.asPieProgress) return;

    var defaults = $.components.getDefaults("pieProgress");

    $('[data-plugin="pieProgress"]', context).each(function() {
      var $this = $(this),
        options = $this.data();

      options = $.extend(true, {}, defaults, options);

      $this.asPieProgress(options);
    });
  }
});

$.components.register("scrollable", {
  mode: "init",
  defaults: {
    namespace: "scrollable",
    contentSelector: "> [data-role='content']",
    containerSelector: "> [data-role='container']"
  },
  init: function(context) {
    if (!$.fn.asScrollable) return;
    var defaults = $.components.getDefaults("scrollable");

    $('[data-plugin="scrollable"]', context).each(function() {
      var options = $.extend({}, defaults, $(this).data());

      $(this).asScrollable(options);
    });
  }
});

$.components.register("loadingButton", {
  mode: "init",
  defaults: {},
  init: function() {
    $(document).on('click.site.loading', '[data-loading-text]', function() {
      var $btn = $(this),
        text = $btn.text(),
        i = 20,
        loadingText = $btn.data('loadingText');

      $btn.text(loadingText + '(' + i + ')').css('opacity', '.6');

      var timeout = setInterval(function() {
        $btn.text(loadingText + '(' + (--i) + ')');
        if (i === 0) {
          clearInterval(timeout);
          $btn.text(text).css('opacity', '1');
        }
      }, 1000);
    });
  }
});

$.components.register("moreButton", {
  mode: "init",
  defaults: {},
  init: function() {
    $(document).on('click.site.morebutton', '[data-more]', function() {
      var $target = $($(this).data('more'));
      $target.toggleClass('show');
    });
  }
});

$.components.register("gmaps", {
  styles: [{
    "featureType": "landscape",
    "elementType": "all",
    "stylers": [{
      "color": "#ffffff"
    }]
  }, {
    "featureType": "poi",
    "elementType": "all",
    "stylers": [{
      "color": "#ffffff"
    }]
  }, {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "700")
    }]
  }, {
    "featureType": "administrative",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "500")
    }]
  }, {
    "featureType": "road.highway",
    "elementType": "geometry.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "300")
    }]
  }, {
    "featureType": "road.arterial",
    "elementType": "geometry.fill",
    "stylers": [{
      "color": "#e0e0e0"
    }]
  }, {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "200")
    }]
  }, {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": "#000000"
    }]
  }, {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "500")
    }]
  }, {
    "featureType": "road",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "poi.attraction",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "poi",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "road.local",
    "elementType": "all",
    "stylers": [{
      "color": $.colors("blue-grey", "200")
    }, {
      "weight": 0.5
    }]
  }, {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [{
      "color": $.colors("blue-grey", "300")
    }]
  }, {
    "featureType": "road.arterial",
    "elementType": "geometry.stroke",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [{
      "visibility": "off"
    }, {
      "color": "#000000"
    }]
  }, {
    "featureType": "poi",
    "elementType": "all",
    "stylers": [{
      "visibility": "off"
    }, {
      "color": "#000000"
    }]
  }, {
    "featureType": "poi",
    "elementType": "labels.text",
    "stylers": [{
      "visibility": "on"
    }, {
      "color": $.colors("blue-grey", "700")
    }]
  }, {
    "featureType": "road.local",
    "elementType": "labels.text",
    "stylers": [{
      "color": $.colors("blue-grey", "700")
    }]
  }, {
    "featureType": "transit",
    "elementType": "all",
    "stylers": [{
      "color": $.colors("blue-grey", "100")
    }]
  }, {
    "featureType": "transit.station",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "500")
    }]
  }, {
    "featureType": "road",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "600")
    }]
  }, {
    "featureType": "administrative.neighborhood",
    "elementType": "labels.text",
    "stylers": [{
      "color": $.colors("blue-grey", "700")
    }]
  }, {
    "featureType": "poi",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "color": "#ffffff"
    }]
  }, {
    "featureType": "road.highway",
    "elementType": "labels.icon",
    "stylers": [{
      "visibility": "on"
    }, {
      "hue": "#ffffff"
    }, {
      "saturation": -100
    }, {
      "lightness": 50
    }]
  }, {
    "featureType": "water",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "visibility": "on"
    }, {
      "color": "#ffffff"
    }]
  }, {
    "featureType": "administrative.neighborhood",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "color": "#ffffff"
    }]
  }, {
    "featureType": "administrative",
    "elementType": "labels.text.stroke",
    "stylers": [{
      "color": "#ffffff"
    }]
  }, {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [{
      "color": $.colors("blue-grey", "600")
    }]
  }]
});

$.components.register("placeholder", {
  mode: "init",
  init: function(context) {
    if (!$.fn.placeholder) return;

    $('input, textarea', context).placeholder();
  }
});

$.components.register("vectorMap", {
  mode: "default",
  defaults: {
    map: "world_mill_en",
    backgroundColor: '#fff',
    zoomAnimate: true,
    regionStyle: {
      initial: {
        fill: $.colors("primary", 600)
      },
      hover: {
        fill: $.colors("primary", 500)
      },
      selected: {
        fill: $.colors("primary", 800)
      },
      selectedHover: {
        fill: $.colors("primary", 500)
      }
    },
    markerStyle: {
      initial: {
        r: 8,
        fill: $.colors("red", 600),
        "stroke-width": 0
      },
      hover: {
        r: 12,
        stroke: $.colors("red", 600),
        "stroke-width": 0
      }
    }
  }
});

$.components.register("masonry", {
  mode: "init",
  defaults: {
    itemSelector: ".masonry-item"
  },
  init: function(context) {
    if (typeof $.fn.masonry === "undefined") return;
    var defaults = $.components.getDefaults('masonry');

    var callback = function() {
      $('[data-plugin="masonry"]', context).each(function() {
        var $this = $(this),
          options = $.extend(true, {}, defaults, $this.data());

        $this.masonry(options);
      });
    }
    if (context !== document) {
      callback();
    } else {
      $(window).on('load', function() {
        callback();
      });
    }
  }
});

$.components.register("matchHeight", {
  mode: "init",
  defaults: {},
  init: function(context) {
    if (typeof $.fn.matchHeight === "undefined") return;
    var defaults = $.components.getDefaults('matchHeight');

    $('[data-plugin="matchHeight"]', context).each(function() {
      var $this = $(this),
        options = $.extend(true, {}, defaults, $this.data()),
        matchSelector = $this.data('matchSelector');

      if (matchSelector) {
        $this.find(matchSelector).matchHeight(options);
      } else {
        $this.children().matchHeight(options);
      }

    });
  }
});

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

$.components.register("plyr", {
  mode: "init",
  init: function() {
    if (typeof plyr === "undefined") return;

    (function(d, u) {
      var a = new XMLHttpRequest(),
        b = d.body;

      // Check for CORS support
      if ("withCredentials" in a) {
        a.open("GET", u, true);
        a.send();
        a.onload = function() {
          var c = d.createElement("div");
          c.style.display = "none";
          c.innerHTML = a.responseText;
          b.insertBefore(c, b.childNodes[0]);
        }
      }
    })(document, "https://cdn.plyr.io/1.1.5/sprite.svg");

    plyr.setup();
  }
});

$.components.register("rating", {
  mode: "init",
  defaults: {
    targetKeep: true,
    icon: "font",
    starType: "i",
    starOff: "icon wb-star",
    starOn: "icon wb-star orange-600",
    cancelOff: "icon wb-minus-circle",
    cancelOn: "icon wb-minus-circle orange-600",
    starHalf: "icon wb-star-half orange-500"
  },
  init: function(context) {
    if (!$.fn.raty) return;

    var defaults = $.components.getDefaults("rating");

    $('[data-plugin="rating"]', context).each(function() {
      var $this = $(this);
      var options = $.extend(true, {}, defaults, $this.data());

      if (options.hints) {
        options.hints = options.hints.split(',');
      }

      $this.raty(options);
    });
  }
});

$.components.register("switchery", {
  mode: "init",
  defaults: {
    color: $.colors("primary", 600)
  },
  init: function(context) {
    if (typeof Switchery === "undefined") return;

    var defaults = $.components.getDefaults("switchery");

    $('[data-plugin="switchery"]', context).each(function() {
      var options = $.extend({}, defaults, $(this).data());

      new Switchery(this, options);
    });
  }
});

$.components.register("verticalTab", {
  mode: "init",
  init: function(context) {
    if (!$.fn.matchHeight) return;

    $('.nav-tabs-vertical', context).each(function() {
      $(this).children().matchHeight();
    });
  }
});

$.components.register("horizontalTab", {
  mode: "init",
  init: function(context) {
    if (!$.fn.responsiveHorizontalTabs) return;

    $('.nav-tabs-horizontal', context).responsiveHorizontalTabs();
  }
});
