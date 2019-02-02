void function ( exports, $, _, Backbone ) {

	var ES_TimelineView = exports.ES_TimelineView = B.View.extend({
		constructor: function ES_TimelineView() {
			B.View.apply(this, arguments);
		},

		bindings: [
			{
				selector: '.timeline-block.duration,.guide-block.duration',
				type: 'style',
				attr: {
					'width': 'duration',
				},
				parse: function ( value, key ) {
					switch ( key ) {
						case 'width':
							return value / 10;
						default:
							return value;
					}
				}
			},
			{
				selector: '.timeline-block .txt-duration',
				type: 'text',
				attr: 'duration',
				parse: function ( value ) {
					return value + 'ms'
				}
			}
		],
		events: {
			'click .timeline-preview-btn': function () {
				this.rootView.startAnimationPreview();
			},
			'click .timeline-resume-btn': function () {
				this.rootView.resumeAnimationPreview();
			},
			'click .timeline-pause-btn': function () {
				this.rootView.pauseAnimationPreview();
			},
			'click .timeline-preview-exit-btn': function () {
				this.rootView.stopAnimationPreview();
			},
			'resizestart .timeline-block.duration': function ( e, ui ) {
				this.rootView.slideAnim.seek(0)
			},
			'resize .timeline-block.duration': function ( e, ui ) {
				this.$('.guide-block.duration').width(ui.size.width)
				this.$('.timeline-block.duration .txt-duration').text(ui.size.width * 10 + 'ms')
			},
			'resizestop .timeline-block.duration': function ( e, ui ) {
				var width = ui.size.width;
				var duration = width * 10;
				this.model.set('duration', duration);
			},
			'resize .timeline-toolbar': function ( e, ui ) {
				this.rootView.layersView.$el.width(ui.size.width)
				this.$('.timeline-guide').css('left',ui.size.width)
			},
			'drag .timeline-cursor': function ( e, ui ) {
				var maxLeft = this.model.get('totalDuration') / 10 + 20;
				if (ui.position.left < 20)
					ui.position.left = 20;
				else if (ui.position.left > maxLeft)
					ui.position.left = maxLeft;
				var time = (ui.position.left - 20) * 10;
				this.rootView.slideAnim.seek(time)
			},
			'dragstart .timeline-cursor': function ( e, ui ) {
				this.isDraggingCursor = true;
				this.rootView.enterAnimationPreview();
				this.rootView.pauseAnimationPreview();
			},
			'dragstop .timeline-cursor': function ( e, ui ) {
				this.isDraggingCursor = false;
				//this.rootView.resumeAnimationPreview();
			}
		},
		modelEvents: {
			'change:duration': function ( model ) {
				this.rootView.slideAnim.duration = model.get('totalDuration');
			}
		},

		initialize: function () {
			this.isDraggingCursor = false;
			this.$toolbar = this.$('.timeline-toolbar');
			this.$slider = this.$('.timeline-slider');
			this.$guide = this.$('.timeline-guide .guide-block');
			this.$txt_msec = this.$('.timeline-time .txt-ms');
			this.$txt_sec = this.$('.timeline-time .txt-sec');
			this.$txt_min = this.$('.timeline-time .txt-min');
			this.$cursor = this.$('.timeline-cursor');
			//

			this.listenTo(this.rootView.slideAnim, 'tick', this.handleAnimationTick);
			this.listenTo(this.rootView.slideAnim, 'end', this.handleAnimationTick);

			this.$toolbar
				.resizable({
					handles: 'e',
					minWidth: 180
				});
			this.$('.timeline-block.duration')
				.resizable({
					handles: 'e',
					grid: [ 10, 0 ],
					minWidth: 100
				})
				.children('.ui-resizable-handle')
				.attr('title', 'Drag me to change duration.')
			this.$('.timeline-block.transition-in')
				.resizable({
					handles: 'e',
					grid: [ 10, 0 ],
					minWidth: 0
				});
			this.$cursor
				.draggable({
					axis: 'x'
				})
			this.renderRuler();
		},
		ready: function(){
			this.renderRuler();
		},
		handleAnimationTick: function ( time ) {

			(time !== undefined) || (time = this.rootView.slideAnim.duration);

			if (!this.isDraggingCursor) {
				var cursorLeft = Math.round(time / 10) + 20;
				this.$cursor.css('left', cursorLeft)
			}

			var ms = (time % 1000).toString();
			var sec = Math.floor(time / 1000).toString();
			while ( ms.length < 3 )
				ms = '0' + ms;
			while ( sec.length < 2 )
				sec = '0' + sec;
			this.$txt_msec.text(ms);
			this.$txt_sec.text(sec);
		},
		renderRuler: function(){
			if ( this._isRenderRuler )
				return;
			var width = 9000;
			var height = this.$('.jsn-es-ruler').height();
			var duration = 5000;
			var offsetX = 0;
			var columnWidth = 10;//parseInt(this.model.get('size'));
			var color = '#6F737D';//this.model.get('color');
			var ctx = $('<svg>');

			//ctx.css({ width: width, height: height });

			// IMPORTANT: Using viewbox attribute will cause SVG scaling on MS Edge browser
			ctx
				.attr('width', width)
				.attr('height', height)
				//.attr('viewbox', '0 0 ' + width + ' ' + height)
				//.attr('preserveAspectRatio', "xMinYMin meet")
				.attr('class', this.$('.jsn-es-ruler').attr('class'));


			// Set x at the slider offset value
			var x = offsetX;
			//console.log($container.find('defs').get(0))
			//var gradientHTML = '<defs>' + $container.find('defs').get(0).innerHTML + '</defs>';
			//log(gradientHTML)
			// Draw draw line by line until it the end of the element
			while ( x >= 0 && x <= (width + columnWidth) ) {

				x % (columnWidth * 5) == 0 &&
				$('<text class="' + (x == 0 ? '' : 'ruler-number ruler-number-top') + '">')
					.text((x / columnWidth / 10).toFixed(1))
					.attr({ y: height - 5, x: x + 2, fill: color })
					.appendTo(ctx);

				$('<line class="timeline-line">').appendTo(ctx)
					.attr({ x1: x - 0.5, x2: x - 0.5, y1: 0 , y2:  x % (columnWidth * 5) == 0 ?  (height - 20) : (height - 20) / 2, stroke: color })
					.css({ opacity: x == 1, 'stroke-width': '1px'});

				x += columnWidth;
			}
			this._isRenderRuler = true;
			this.$('.jsn-es-ruler').remove();
			this.$('.timeline-slider').prepend( ctx.get(0).outerHTML );
		}
	});

}(this, jQuery, _, JSNES_Backbone);