/*

Elfsight Instagram Feed
Version: 3.5.0
Release date: Wed May 23 2018

https://elfsight.com

Copyright (c) 2018 Elfsight, LLC. ALL RIGHTS RESERVED

*/(function(eapps) {

    var colorSchemes = {
        'default': {
            'colorPostBg': 'rgb(255, 255, 255)',
            'colorPostText': 'rgb(0, 0, 0)',
            'colorPostLinks': 'rgb(0, 53, 105)',
            'colorPostOverlayBg': 'rgba(0, 0, 0, 0.8)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(255, 255, 255)',
            'colorSliderArrowsBg': 'rgba(0, 0, 0, 0.9)',
            'colorGridLoadMoreButton': 'rgb(56, 151, 240)',
            'colorPopupOverlay': 'rgba(43, 43, 43, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(0, 0, 0)',
            'colorPopupLinks': 'rgb(0, 53, 105)',
            'colorPopupFollowButton': 'rgb(0, 53, 105)',
            'colorPopupCtaButton': 'rgb(56, 151, 240)'
        },
        'sky': {
            'colorPostBg': 'rgb(33, 150, 243)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(33, 150, 243, 0.9)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(0, 142, 255)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(43, 43, 43, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(0, 0, 0)',
            'colorPopupLinks': 'rgb(0, 142, 255)',
            'colorPopupFollowButton': 'rgb(0, 142, 255)',
            'colorPopupCtaButton': 'rgb(0, 142, 255)',
        },
        'dark': {
            'colorPostBg': 'rgb(28, 27, 27)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(28, 27, 27, 0.9)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(176, 176, 176)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(0, 0, 0, 0.9)',
            'colorPopupBg': 'rgb(49, 49, 49)',
            'colorPopupText': 'rgb(255, 255, 255)',
            'colorPopupLinks': 'rgb(30, 136, 241)',
            'colorPopupFollowButton': 'rgb(30, 136, 241)',
            'colorPopupCtaButton': 'rgb(30, 136, 241)',
        },
        'emerald': {
            'colorPostBg': 'rgb(0, 162, 65)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(0, 162, 65, 0.97)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(0, 154, 91)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(6, 156, 119, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(68, 68, 68)',
            'colorPopupLinks': 'rgb(0, 143, 57)',
            'colorPopupFollowButton': 'rgb(0, 143, 57)',
            'colorPopupCtaButton': 'rgb(0, 143, 57)',
        },
        'jeans': {
            'colorPostBg': 'rgb(0, 65, 98)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(0, 65, 98, 0.97)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(160, 88, 30)',
            'colorSliderArrowsBg': 'rgb(229, 182, 116)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(0, 18, 28, 0.9)',
            'colorPopupBg': 'rgb(14, 60, 84)',
            'colorPopupText': 'rgb(255, 255, 255)',
            'colorPopupLinks': 'rgb(255, 182, 80)',
            'colorPopupFollowButton': 'rgb(255, 182, 80)',
            'colorPopupCtaButton': 'rgb(255, 182, 80)',
        },
        'leather': {
            'colorPostBg': 'rgb(163, 90, 36)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(163, 90, 36, 0.97)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(239, 129, 0)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(108, 40, 11, 0.9)',
            'colorPopupBg': 'rgb(255, 252, 235)',
            'colorPopupText': 'rgb(44, 24, 0)',
            'colorPopupLinks': 'rgb(239, 129, 0)',
            'colorPopupFollowButton': 'rgb(239, 129, 0)',
            'colorPopupCtaButton': 'rgb(239, 129, 0)',
        },
        'light': {
            'colorPostBg': 'rgb(237, 237, 237)',
            'colorPostText': 'rgb(0, 0, 0)',
            'colorPostLinks': 'rgb(0, 0, 0)',
            'colorPostOverlayBg': 'rgba(237, 237, 237, 0.9)',
            'colorPostOverlayText': 'rgb(0, 0, 0)',
            'colorSliderArrows': 'rgb(0, 156, 255)',
            'colorSliderArrowsBg': 'rgb(255, 255, 255)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(228, 228, 228, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(68, 68, 68)',
            'colorPopupLinks': 'rgb(0, 156, 255)',
            'colorPopupFollowButton': 'rgb(0, 156, 255)',
            'colorPopupCtaButton': 'rgb(0, 156, 255)',
        },
        'night-life': {
            'colorPostBg': 'rgb(86, 44, 122)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(86, 44, 122, 0.97)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(182, 102, 255)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(86, 44, 122, 0.9)',
            'colorPopupBg': 'rgb(37, 37, 37)',
            'colorPopupText': 'rgb(255, 255, 255)',
            'colorPopupLinks': 'rgb(182, 102, 255)',
            'colorPopupFollowButton': 'rgb(182, 102, 255)',
            'colorPopupCtaButton': 'rgb(182, 102, 255)',
        },
        'orange': {
            'colorPostBg': 'rgb(255, 126, 0)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(255, 126, 0, 0.9)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(255, 126, 0)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(242, 134, 29, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(0, 0, 0)',
            'colorPopupLinks': 'rgb(255, 144, 0)',
            'colorPopupFollowButton': 'rgb(255, 144, 0)',
            'colorPopupCtaButton': 'rgb(255, 144, 0)',
        },
        'red-power': {
            'colorPostBg': 'rgb(190, 13, 13)',
            'colorPostText': 'rgb(255, 255, 255)',
            'colorPostLinks': 'rgb(255, 255, 255)',
            'colorPostOverlayBg': 'rgba(190, 13, 13, 0.97)',
            'colorPostOverlayText': 'rgb(255, 255, 255)',
            'colorSliderArrows': 'rgb(255, 38, 38)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(221, 26, 26, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(68, 68, 68)',
            'colorPopupLinks': 'rgb(255, 38, 38)',
            'colorPopupFollowButton': 'rgb(255, 38, 38)',
            'colorPopupCtaButton': 'rgb(255, 38, 38)',
        },
        'yellow': {
            'colorPostBg': 'rgb(255, 235, 14)',
            'colorPostText': 'rgb(0, 0, 0)',
            'colorPostLinks': 'rgb(0, 0, 0)',
            'colorPostOverlayBg': 'rgba(255, 235, 14, 0.9)',
            'colorPostOverlayText': 'rgb(0, 0, 0)',
            'colorSliderArrows': 'rgb(163, 163, 163)',
            'colorSliderArrowsBg': 'rgba(255, 255, 255, 0.9)',
            'colorGridLoadMoreButton': '',
            'colorPopupOverlay': 'rgba(223, 190, 5, 0.9)',
            'colorPopupBg': 'rgb(255, 255, 255)',
            'colorPopupText': 'rgb(0, 0, 0)',
            'colorPopupLinks': 'rgb(223, 194, 0)',
            'colorPopupFollowButton': 'rgb(223, 194, 0)',
            'colorPopupCtaButton': 'rgb(223, 194, 0)',
        },
        'custom': {
        }
    };

    var colorKeys = [
        'colorPostBg',
        'colorPostText',
        'colorPostArrows',
        'colorPostArrowsBg',
    ];

    var watchColorKeys = [];

    for (var i = 0, j = colorKeys.length; i < j; i++) {
        watchColorKeys.push('widget.data.' + colorKeys[i]);
    }
    var watchColorTimer;
    var customPrestine = true;
    var colorSchemeChanging = false;

    function adaptOptions(options) {
        var matches = {
            postElements: 'info',
            popupElements: 'popupInfo',
            sliderArrows: 'arrowsControl',
            sliderDrag: 'dragControl',
            sliderSpeed: 'speed',
            sliderAutoplay: 'auto',
            imageClickAction: 'mode',
            cacheTime: 'cacheMediaTime',
            colorPostOverlayText: 'colorGalleryDescription',
            colorPostOverlayBg: 'colorGalleryOverlay',
            colorSliderArrows: 'colorGalleryArrows',
            colorSliderArrowsBg: 'colorGalleryArrowsBg',
            colorPopupLinks: 'colorPopupAnchor',
            colorPopupFollowButton: 'colorPopupInstagramLink'
        };

        var oldColors = ['colorGalleryDescription', 'colorGalleryOverlay', 'colorGalleryArrows', 'colorGalleryArrowsBg', 'colorPopupAnchor', 'colorPopupInstagramLink'];

        for (var name in matches) {
            var oldName = matches[name];

            if (options.hasOwnProperty(oldName)) {
                if (oldName === 'info' || oldName === 'popupInfo') {
                    if (Array.isArray(options[oldName])) {
                        options[oldName] = options[oldName].join(' ');
                    }

                    options[oldName] = (options[oldName] || '')
                        .replace('username', 'user')
                        .replace('likesCounter', 'likesCount')
                        .replace('commentsCounter', 'commentsCount')
                        .replace('description', 'text');

                    options[oldName] = options[oldName].split(' ');
                }

                if (oldName === 'auto' || oldName === 'speed') {
                    options[oldName] = parseFloat((parseInt(options[oldName], 10) / 1000).toFixed(2));
                }

                options[name] = options[oldName];

                if (oldColors.indexOf(oldName) !== -1 && options[oldName]) {
                    options.colorScheme = 'custom';
                }

                delete options[oldName];
            }
        }

        return options;
    }

    eapps.observer = function($scope, properties) {

        $scope.widget.data = adaptOptions($scope.widget.data);

        var postTileColors;
        var postClassicColors;
        var layoutsProperties = {
            slider: ['layoutSlider']
        };

        angular.forEach(properties, function(item) {
            if (item.id === 'colorsPostTile') {
                postTileColors = item;

            } else if (item.id === 'colorsPostClassic') {
                postClassicColors = item;
            }
        });

        $scope.$watch('widget.data.layout', function (newValue) {
            Object.keys(layoutsProperties).forEach(function (layout) {
                var visible = layout === newValue;

                layoutsProperties[layout].forEach((property)=> {
                    properties.find(obj => obj.id === property).visible = visible
                })
            });
        });

        $scope.$watch('widget.data.postTemplate', function(newValue, oldValue) {
            var gutter = $scope.widget.data.gutter;

            if (gutter === 0 || gutter === 20) {
                var newGutter = (newValue === 'tile') ? 0 : 20;

                if (newGutter !== gutter) {
                    $scope.widget.data.gutter = newGutter;
                }
            }

            if (newValue === 'tile') {
                postClassicColors.visible = false;
                postTileColors.visible = true;

            } else if (newValue === 'classic') {
                postClassicColors.visible = true;
                postTileColors.visible = false;
            }
        });

        $scope.$watch('widget.data.colorScheme', function(newValue, oldValue) {
            if (newValue !== undefined && newValue !== oldValue && newValue in colorSchemes) {
                angular.extend($scope.widget.data, colorSchemes[newValue]);
                colorSchemeChanging = true;
            }
        });

        $scope.$watchGroup(watchColorKeys, function(newValues, oldValues) {
            if (!colorSchemeChanging) {
                customPrestine = false;
            }

            clearTimeout(watchColorTimer);

            watchColorTimer = setTimeout(function() {
                if (newValues !== undefined && newValues !== oldValues) {
                    // don't change the custom scheme colors if any color was changed before
                    if ((customPrestine && colorSchemeChanging) || (!customPrestine && !colorSchemeChanging)) {
                        for (var i = 0, j = colorKeys.length; i < j; i++) {
                            colorSchemes['custom'][colorKeys[i]] = newValues[i];
                        }
                    }

                    if (!colorSchemeChanging && $scope.widget.data.colorScheme !== 'custom') {
                        $scope.widget.data.colorScheme = 'custom';
                    }

                    colorSchemeChanging = false;
                }
            }, 300);
        });
    };
})(window.eapps = window.eapps || {});