app.directive('carousel', Carousel)
    .directive('carouselSlide', CarouselSlide);

function Carousel() {
    return {
        scope: false,
        restrict: 'E',
        replace: true,
        template: '' +
        '<div class="carousel-container">' +
            '<div class="carousel-wrapper">' +
                '<div class="carousel-animator" ng-style="getAnimatorStyles()">' +
                    '<div class="carousel-slides-container">' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="before"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="before"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="before"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="before"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="after"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="after"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="after"></carousel-slide>' +
                        '<carousel-slide ng-repeat="slide in slides" slide="slide" duplicate="after"></carousel-slide>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>',
        link: function(scope, element) {

            scope.container = element;
            scope.wrapper = scope.container.children().eq(0);
            scope.animator = scope.wrapper.children().eq(0);
            scope.slidesContainer = scope.animator.children().eq(0);

            scope.animatorWidth = 0;
            scope.animatorPosition = 0;
            scope.animationRunning = false;

            scope.slides = [];

            scope.$watch('slides', function() {
                if (scope.slides.length > 0) {
                    _calcDimensions();
                    _checkAnimationAllowance();
                }
            }, true);

            scope.getAnimatorStyles = function() {
                return {
                    'width': scope.animatorWidth + 'px',
                    'margin-left': -(scope.animatorWidth / 2) + 'px',
                    'transform': 'translateX(' + scope.animatorPosition + 'px)'
                };
            };

            function _animationStep() {
                if (scope.animationRunning) {
                    _updateAnimatorPosition(scope.animatorPosition -= 0.25);
                    scope.animationFrameRequest = window.requestAnimationFrame(_animationStep);
                }
            }

            function _startAnimation() {
                if (scope.animationFrameRequest) {
                    _stopAnimation();
                }
                scope.animationRunning = true;
                scope.animationFrameRequest = window.requestAnimationFrame(_animationStep);
            }

            function _stopAnimation() {
                scope.animationRunning = false;
                if (scope.animationFrameRequest) {
                    window.cancelAnimationFrame(scope.animationFrameRequest);
                    delete scope.animationFrameRequest;
                }
            }

            function _getAnimationThreshold() {
                var wrapperWidth = scope.wrapper[0].getBoundingClientRect().width;
                return (scope.animatorWidth - wrapperWidth) / 2 + scope.animatorWidth;
            }

            function _getPositionWithBounds(posX) {
                var animationThreshold = _getAnimationThreshold();
                if (posX > animationThreshold) {
                    posX = posX - scope.animatorWidth;
                } else if (posX < -animationThreshold) {
                    posX = posX + scope.animatorWidth;
                }
                scope.impetus.setValues(posX, 0);
                return posX;
            }

            function _updateAnimatorPosition(posX) {
                scope.$apply(function() {
                    scope.animatorPosition = _getPositionWithBounds(posX);
                });
            }

            function _checkAnimationAllowance() {
                var animationAllowed = _isElementVisible(scope.container[0]);
                if (scope.animationRunning && !animationAllowed) {
                    _stopAnimation();
                } else if (!scope.animationRunning && animationAllowed) {
                    _startAnimation();
                }
            }

            function _isElementVisible(element) {
                var rect = element.getBoundingClientRect();
                var visible = {
                    bottom: (rect.top + rect.height) >= 0,
                    right: (rect.left + rect.width) >= 0,
                    top: (rect.bottom - rect.height) <= (window.innerHeight || document.documentElement.clientHeight),
                    left: (rect.right - rect.width) <= (window.innerWidth || document.documentElement.clientWidth)
                };
                return visible.top && visible.bottom && visible.left && visible.right;
            }

            function _bindEvents() {
                scope.impetus = new Impetus({
                    source: scope.wrapper[0],
                    update: _updateAnimatorPosition
                });

                scope.wrapper
                    .bind('mouseenter touchstart', function() {
                        scope.$apply(_stopAnimation);
                    })
                    .bind('mouseleave touchend', function() {
                        scope.$apply(_startAnimation);
                    });

                angular.element(window)
                    .bind('scroll resize', _checkAnimationAllowance);
            }

            function _getChannelData() {
                scope.slides = slides;
            }

            function _calcDimensions() {
                var slides = scope.slidesContainer.children();
                var slide = slides.length > 0 ? slides[0] : null;
                var slideWidth = slide ? slide.getBoundingClientRect().width : 0;
                var slideTotal = scope.slides.length;
                scope.animatorWidth = (slideWidth * slideTotal);
            }

            function _init() {
                _getChannelData();
                _bindEvents();
            }

            _init();
        }
    };
}

function CarouselSlide() {
    return {
        scope: {
            slide: "=",
            duplicate: "@"
        },
        restrict: 'E',
        replace: true,
        template:'' +
            '<div class="item">' +
                '<div class="date">{{slide.date}}</div>' +
                '<div class="sub_item" ng-repeat="(key, event) in slide.events">' +
                    '<a href="{{event.link}}" class="title">{{event.title}}</a>' +
                    '<p class="description" style="white-space: normal;">{{event.description}}</p>' +
                    '<span class="time">{{event.time}}</span>' +
                '</div>' +
            '</div>',
        link: function(scope) {

            scope.getSlideClasses = function() {
                return {
                    'duplicate': scope.duplicate,
                    'before': scope.duplicate === 'before',
                    'after': scope.duplicate === 'after'
                };
            };

        }
    };
}