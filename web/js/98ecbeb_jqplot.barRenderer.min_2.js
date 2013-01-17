(function(w){w.jqplot.BarRenderer=function(){w.jqplot.LineRenderer.call(this)};w.jqplot.BarRenderer.prototype=new w.jqplot.LineRenderer();w.jqplot.BarRenderer.prototype.constructor=w.jqplot.BarRenderer;w.jqplot.BarRenderer.prototype.init=function(c,a){this.barPadding=8;this.barMargin=10;this.barDirection="vertical";this.barWidth=null;this.shadowOffset=2;this.shadowDepth=5;this.shadowAlpha=0.08;this.waterfall=false;this.groups=1;this.varyBarColor=false;this.highlightMouseOver=true;this.highlightMouseDown=false;this.highlightColors=[];this.transposedData=true;this.renderer.animation={show:false,direction:"down",speed:3000,_supported:true};this._type="bar";if(c.highlightMouseDown&&c.highlightMouseOver==null){c.highlightMouseOver=false}w.extend(true,this,c);w.extend(true,this.renderer,c);this.fill=true;if(this.barDirection==="horizontal"&&this.rendererOptions.animation&&this.rendererOptions.animation.direction==null){this.renderer.animation.direction="left"}if(this.waterfall){this.fillToZero=false;this.disableStack=true}if(this.barDirection=="vertical"){this._primaryAxis="_xaxis";this._stackAxis="y";this.fillAxis="y"}else{this._primaryAxis="_yaxis";this._stackAxis="x";this.fillAxis="x"}this._highlightedPoint=null;this._plotSeriesInfo=null;this._dataColors=[];this._barPoints=[];var b={lineJoin:"miter",lineCap:"round",fill:true,isarc:false,strokeStyle:this.color,fillStyle:this.color,closePath:this.fill};this.renderer.shapeRenderer.init(b);var d={lineJoin:"miter",lineCap:"round",fill:true,isarc:false,angle:this.shadowAngle,offset:this.shadowOffset,alpha:this.shadowAlpha,depth:this.shadowDepth,closePath:this.fill};this.renderer.shadowRenderer.init(d);a.postInitHooks.addOnce(s);a.postDrawHooks.addOnce(q);a.eventListenerHooks.addOnce("jqplotMouseMove",y);a.eventListenerHooks.addOnce("jqplotMouseDown",z);a.eventListenerHooks.addOnce("jqplotMouseUp",o);a.eventListenerHooks.addOnce("jqplotClick",v);a.eventListenerHooks.addOnce("jqplotRightClick",n)};function t(i,c,d,f){if(this.rendererOptions.barDirection=="horizontal"){this._stackAxis="x";this._primaryAxis="_yaxis"}if(this.rendererOptions.waterfall==true){this._data=w.extend(true,[],this.data);var j=0;var h=(!this.rendererOptions.barDirection||this.rendererOptions.barDirection==="vertical"||this.transposedData===false)?1:0;for(var b=0;b<this.data.length;b++){j+=this.data[b][h];if(b>0){this.data[b][h]+=this.data[b-1][h]}}this.data[this.data.length]=(h==1)?[this.data.length+1,j]:[j,this.data.length+1];this._data[this._data.length]=(h==1)?[this._data.length+1,j]:[j,this._data.length+1]}if(this.rendererOptions.groups>1){this.breakOnNull=true;var e=this.data.length;var g=parseInt(e/this.rendererOptions.groups,10);var a=0;for(var b=g;b<e;b+=g){this.data.splice(b+a,0,[null,null]);this._plotData.splice(b+a,0,[null,null]);this._stackData.splice(b+a,0,[null,null]);a++}for(b=0;b<this.data.length;b++){if(this._primaryAxis=="_xaxis"){this.data[b][0]=b+1;this._plotData[b][0]=b+1;this._stackData[b][0]=b+1}else{this.data[b][1]=b+1;this._plotData[b][1]=b+1;this._stackData[b][1]=b+1}}}}w.jqplot.preSeriesInitHooks.push(t);w.jqplot.BarRenderer.prototype.calcSeriesNumbers=function(){var c=0;var b=0;var d=this[this._primaryAxis];var e,f,a;for(var g=0;g<d._series.length;g++){f=d._series[g];if(f===this){a=g}if(f.renderer.constructor==w.jqplot.BarRenderer){c+=f.data.length;b+=1}}return[c,b,a]};w.jqplot.BarRenderer.prototype.setBarWidth=function(){var b;var e=0;var d=0;var j=this[this._primaryAxis];var f,a,h;var g=this._plotSeriesInfo=this.renderer.calcSeriesNumbers.call(this);e=g[0];d=g[1];var i=j.numberTicks;var c=(i-1)/2;if(j.name=="xaxis"||j.name=="x2axis"){if(this._stack){this.barWidth=(j._offsets.max-j._offsets.min)/e*d-this.barMargin}else{this.barWidth=((j._offsets.max-j._offsets.min)/c-this.barPadding*(d-1)-this.barMargin*2)/d}}else{if(this._stack){this.barWidth=(j._offsets.min-j._offsets.max)/e*d-this.barMargin}else{this.barWidth=((j._offsets.min-j._offsets.max)/c-this.barPadding*(d-1)-this.barMargin*2)/d}}return[e,d]};function u(f){var d=[];for(var b=0;b<f.length;b++){var c=w.jqplot.getColorComponents(f[b]);var g=[c[0],c[1],c[2]];var a=g[0]+g[1]+g[2];for(var e=0;e<3;e++){g[e]=(a>570)?g[e]*0.8:g[e]+0.3*(255-g[e]);g[e]=parseInt(g[e],10)}d.push("rgb("+g[0]+","+g[1]+","+g[2]+")")}return d}function r(g,h,j,i,d){var b=g,f=g-1,e,c,a=(d==="x")?0:1;if(b>0){c=i.series[f]._plotData[h][a];if((j*c)<0){e=r(f,h,j,i,d)}else{e=i.series[f].gridData[h][a]}}else{e=(a===0)?i.series[b]._xaxis.series_u2p(0):i.series[b]._yaxis.series_u2p(0)}return e}w.jqplot.BarRenderer.prototype.draw=function(V,e,ab,R){var j;var ac=w.extend({},ab);var m=(ac.shadow!=undefined)?ac.shadow:this.shadow;var b=(ac.showLine!=undefined)?ac.showLine:this.showLine;var T=(ac.fill!=undefined)?ac.fill:this.fill;var ad=this.xaxis;var h=this.yaxis;var i=this._xaxis.series_u2p;var g=this._yaxis.series_u2p;var X,Z;this._dataColors=[];this._barPoints=[];if(this.barWidth==null){this.renderer.setBarWidth.call(this)}var c=this._plotSeriesInfo=this.renderer.calcSeriesNumbers.call(this);var k=c[0];var Q=c[1];var W=c[2];var l=[];if(this._stack){this._barNudge=0}else{this._barNudge=(-Math.abs(Q/2-0.5)+W)*(this.barWidth+this.barPadding)}if(b){var S=new w.jqplot.ColorGenerator(this.negativeSeriesColors);var aa=new w.jqplot.ColorGenerator(this.seriesColors);var d=S.get(this.index);if(!this.useNegativeColors){d=ac.fillStyle}var U=ac.fillStyle;var Y;var a;var ae;if(this.barDirection=="vertical"){for(var j=0;j<e.length;j++){if(!this._stack&&this.data[j][1]==null){continue}l=[];Y=e[j][0]+this._barNudge;if(this._stack&&this._prevGridData.length){ae=r(this.index,j,this._plotData[j][1],R,"y")}else{if(this.fillToZero){ae=this._yaxis.series_u2p(0)}else{if(this.waterfall&&j>0&&j<this.gridData.length-1){ae=this.gridData[j-1][1]}else{if(this.waterfall&&j==0&&j<this.gridData.length-1){if(this._yaxis.min<=0&&this._yaxis.max>=0){ae=this._yaxis.series_u2p(0)}else{if(this._yaxis.min>0){ae=V.canvas.height}else{ae=0}}}else{if(this.waterfall&&j==this.gridData.length-1){if(this._yaxis.min<=0&&this._yaxis.max>=0){ae=this._yaxis.series_u2p(0)}else{if(this._yaxis.min>0){ae=V.canvas.height}else{ae=0}}}else{ae=V.canvas.height}}}}}if((this.fillToZero&&this._plotData[j][1]<0)||(this.waterfall&&this._data[j][1]<0)){if(this.varyBarColor&&!this._stack){if(this.useNegativeColors){ac.fillStyle=S.next()}else{ac.fillStyle=aa.next()}}else{ac.fillStyle=d}}else{if(this.varyBarColor&&!this._stack){ac.fillStyle=aa.next()}else{ac.fillStyle=U}}if(!this.fillToZero||this._plotData[j][1]>=0){l.push([Y-this.barWidth/2,ae]);l.push([Y-this.barWidth/2,e[j][1]]);l.push([Y+this.barWidth/2,e[j][1]]);l.push([Y+this.barWidth/2,ae])}else{l.push([Y-this.barWidth/2,e[j][1]]);l.push([Y-this.barWidth/2,ae]);l.push([Y+this.barWidth/2,ae]);l.push([Y+this.barWidth/2,e[j][1]])}this._barPoints.push(l);if(m&&!this._stack){var f=w.extend(true,{},ac);delete f.fillStyle;this.renderer.shadowRenderer.draw(V,l,f)}var af=ac.fillStyle||this.color;this._dataColors.push(af);this.renderer.shapeRenderer.draw(V,l,ac)}}else{if(this.barDirection=="horizontal"){for(var j=0;j<e.length;j++){if(!this._stack&&this.data[j][0]==null){continue}l=[];Y=e[j][1]-this._barNudge;a;if(this._stack&&this._prevGridData.length){a=r(this.index,j,this._plotData[j][0],R,"x")}else{if(this.fillToZero){a=this._xaxis.series_u2p(0)}else{if(this.waterfall&&j>0&&j<this.gridData.length-1){a=this.gridData[j-1][0]}else{if(this.waterfall&&j==0&&j<this.gridData.length-1){if(this._xaxis.min<=0&&this._xaxis.max>=0){a=this._xaxis.series_u2p(0)}else{if(this._xaxis.min>0){a=0}else{a=0}}}else{if(this.waterfall&&j==this.gridData.length-1){if(this._xaxis.min<=0&&this._xaxis.max>=0){a=this._xaxis.series_u2p(0)}else{if(this._xaxis.min>0){a=0}else{a=V.canvas.width}}}else{a=0}}}}}if((this.fillToZero&&this._plotData[j][1]<0)||(this.waterfall&&this._data[j][1]<0)){if(this.varyBarColor&&!this._stack){if(this.useNegativeColors){ac.fillStyle=S.next()}else{ac.fillStyle=aa.next()}}}else{if(this.varyBarColor&&!this._stack){ac.fillStyle=aa.next()}else{ac.fillStyle=U}}if(!this.fillToZero||this._plotData[j][0]>=0){l.push([a,Y+this.barWidth/2]);l.push([a,Y-this.barWidth/2]);l.push([e[j][0],Y-this.barWidth/2]);l.push([e[j][0],Y+this.barWidth/2])}else{l.push([e[j][0],Y+this.barWidth/2]);l.push([e[j][0],Y-this.barWidth/2]);l.push([a,Y-this.barWidth/2]);l.push([a,Y+this.barWidth/2])}this._barPoints.push(l);if(m&&!this._stack){var f=w.extend(true,{},ac);delete f.fillStyle;this.renderer.shadowRenderer.draw(V,l,f)}var af=ac.fillStyle||this.color;this._dataColors.push(af);this.renderer.shapeRenderer.draw(V,l,ac)}}}}if(this.highlightColors.length==0){this.highlightColors=w.jqplot.computeHighlightColors(this._dataColors)}else{if(typeof(this.highlightColors)=="string"){var c=this.highlightColors;this.highlightColors=[];for(var j=0;j<this._dataColors.length;j++){this.highlightColors.push(c)}}}};w.jqplot.BarRenderer.prototype.drawShadow=function(a,h,R,P){var L;var g=(R!=undefined)?R:{};var m=(g.shadow!=undefined)?g.shadow:this.shadow;var d=(g.showLine!=undefined)?g.showLine:this.showLine;var Q=(g.fill!=undefined)?g.fill:this.fill;var S=this.xaxis;var l=this.yaxis;var i=this._xaxis.series_u2p;var j=this._yaxis.series_u2p;var c,N,e,k,K,M;if(this._stack&&this.shadow){if(this.barWidth==null){this.renderer.setBarWidth.call(this)}var f=this._plotSeriesInfo=this.renderer.calcSeriesNumbers.call(this);k=f[0];K=f[1];M=f[2];if(this._stack){this._barNudge=0}else{this._barNudge=(-Math.abs(K/2-0.5)+M)*(this.barWidth+this.barPadding)}if(d){if(this.barDirection=="vertical"){for(var L=0;L<h.length;L++){if(this.data[L][1]==null){continue}N=[];var O=h[L][0]+this._barNudge;var T;if(this._stack&&this._prevGridData.length){T=r(this.index,L,this._plotData[L][1],P,"y")}else{if(this.fillToZero){T=this._yaxis.series_u2p(0)}else{T=a.canvas.height}}N.push([O-this.barWidth/2,T]);N.push([O-this.barWidth/2,h[L][1]]);N.push([O+this.barWidth/2,h[L][1]]);N.push([O+this.barWidth/2,T]);this.renderer.shadowRenderer.draw(a,N,g)}}else{if(this.barDirection=="horizontal"){for(var L=0;L<h.length;L++){if(this.data[L][0]==null){continue}N=[];var O=h[L][1]-this._barNudge;var b;if(this._stack&&this._prevGridData.length){b=r(this.index,L,this._plotData[L][0],P,"x")}else{if(this.fillToZero){b=this._xaxis.series_u2p(0)}else{b=0}}N.push([b,O+this.barWidth/2]);N.push([h[L][0],O+this.barWidth/2]);N.push([h[L][0],O-this.barWidth/2]);N.push([b,O-this.barWidth/2]);this.renderer.shadowRenderer.draw(a,N,g)}}}}}};function s(a,b,d){for(var c=0;c<this.series.length;c++){if(this.series[c].renderer.constructor==w.jqplot.BarRenderer){if(this.series[c].highlightMouseOver){this.series[c].highlightMouseDown=false}}}}function q(){if(this.plugins.barRenderer&&this.plugins.barRenderer.highlightCanvas){this.plugins.barRenderer.highlightCanvas.resetCanvas();this.plugins.barRenderer.highlightCanvas=null}this.plugins.barRenderer={highlightedSeriesIndex:null};this.plugins.barRenderer.highlightCanvas=new w.jqplot.GenericCanvas();this.eventCanvas._elem.before(this.plugins.barRenderer.highlightCanvas.createElement(this._gridPadding,"jqplot-barRenderer-highlight-canvas",this._plotDimensions,this));this.plugins.barRenderer.highlightCanvas.setContext();this.eventCanvas._elem.bind("mouseleave",{plot:this},function(a){p(a.data.plot)})}function x(a,b,d,e){var f=a.series[b];var g=a.plugins.barRenderer.highlightCanvas;g._ctx.clearRect(0,0,g._ctx.canvas.width,g._ctx.canvas.height);f._highlightedPoint=d;a.plugins.barRenderer.highlightedSeriesIndex=b;var c={fillStyle:f.highlightColors[d]};f.renderer.shapeRenderer.draw(g._ctx,e,c);g=null}function p(a){var c=a.plugins.barRenderer.highlightCanvas;c._ctx.clearRect(0,0,c._ctx.canvas.width,c._ctx.canvas.height);for(var b=0;b<a.series.length;b++){a.series[b]._highlightedPoint=null}a.plugins.barRenderer.highlightedSeriesIndex=null;a.target.trigger("jqplotDataUnhighlight");c=null}function y(d,e,a,b,c){if(b){var f=[b.seriesIndex,b.pointIndex,b.data];var g=jQuery.Event("jqplotDataMouseOver");g.pageX=d.pageX;g.pageY=d.pageY;c.target.trigger(g,f);if(c.series[f[0]].highlightMouseOver&&!(f[0]==c.plugins.barRenderer.highlightedSeriesIndex&&f[1]==c.series[f[0]]._highlightedPoint)){var h=jQuery.Event("jqplotDataHighlight");h.which=d.which;h.pageX=d.pageX;h.pageY=d.pageY;c.target.trigger(h,f);x(c,b.seriesIndex,b.pointIndex,b.points)}}else{if(b==null){p(c)}}}function z(d,e,a,b,c){if(b){var f=[b.seriesIndex,b.pointIndex,b.data];if(c.series[f[0]].highlightMouseDown&&!(f[0]==c.plugins.barRenderer.highlightedSeriesIndex&&f[1]==c.series[f[0]]._highlightedPoint)){var g=jQuery.Event("jqplotDataHighlight");g.which=d.which;g.pageX=d.pageX;g.pageY=d.pageY;c.target.trigger(g,f);x(c,b.seriesIndex,b.pointIndex,b.points)}}else{if(b==null){p(c)}}}function o(d,e,a,b,c){var f=c.plugins.barRenderer.highlightedSeriesIndex;if(f!=null&&c.series[f].highlightMouseDown){p(c)}}function v(d,e,a,b,c){if(b){var f=[b.seriesIndex,b.pointIndex,b.data];var g=jQuery.Event("jqplotDataClick");g.which=d.which;g.pageX=d.pageX;g.pageY=d.pageY;c.target.trigger(g,f)}}function n(d,e,a,b,c){if(b){var f=[b.seriesIndex,b.pointIndex,b.data];var h=c.plugins.barRenderer.highlightedSeriesIndex;if(h!=null&&c.series[h].highlightMouseDown){p(c)}var g=jQuery.Event("jqplotDataRightClick");g.which=d.which;g.pageX=d.pageX;g.pageY=d.pageY;c.target.trigger(g,f)}}})(jQuery);