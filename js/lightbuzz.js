/* (c) Kalamun 2009 - GPL 3 */

/* lightbuzz */
kLightbuzz=function() {
	var link=null,page=null,container=null,bkg=null,msg=null,img=null,caption=null,leftArrow=null,rightArrow=null;
	var elements=Array();

	this.setContainer=function(c) {
		page=document.getElementById(c);
		}

	this.init=function() {
		if(!page) page=document.body;
		var elm=page.getElementsByTagName('A');
		for(var i=0;elm[i];i++) {
			if(elm[i].rel&&elm[i].rel=="lightbuzz") elm[i].onclick=onClickHandler;
			else if(elm[i].rel&&elm[i].rel.match(/^lightbuzz(\[.*?\])?$/)) {
				elm[i].onclick=onClickHandler;
				var rel=elm[i].rel.substr(10).replace("]","");
				if(!elements[rel]) elements[rel]=Array();
				elements[rel][elements[rel].length]=elm[i];
				}
			}
		}
	var onClickHandler=function() {
		link=this;
		open(this.href);
		return false;
		}
	this.onClickHandler=onClickHandler;

	var open=function(url) {
		container=document.createElement('DIV');
		container.id='lightBuzzContainer';
		document.body.appendChild(container);
		
		msg=document.createElement('DIV');
		msg.className='container';
		msg.style.position='absolute';
		msg.style.top='-3000px';
		msg.style.left='-3000px';
		msg.style.zIndex='1001';
		container.appendChild(msg);
		
		img=document.createElement('IMG');
		msg.onclick=closeIPopUp;
		img.onload=onImageLoadsHandler;
		img.src=url;
		msg.appendChild(img);

		caption=document.createElement('DIV');
		caption.className='caption';
		msg.appendChild(caption);
		
		bkg=document.createElement('DIV');
		bkg.className='bkg loading';
		container.appendChild(bkg);
		bkg.style.opacity=.7;
		bkg.onclick=close;
		
		//arrows
		if(rightArrow) rightArrow.parentNode.removeChild(rightArrow);
		if(leftArrow) leftArrow.parentNode.removeChild(leftArrow);
		var rel=link.rel.substr(10).replace("]","");
		if(elements[rel]) {
			document.body.addEventListener("keydown",keyDownHandler,false);
			rightArrow=document.createElement('DIV');
			rightArrow.className='rightArrow';
			rightArrow.onclick=nextImageHandler;
			rightArrow.style.display='none';
			rightArrow.style.top=(kWindow.clientHeight()-rightArrow.offsetHeight)/2+'px';
			container.appendChild(rightArrow);
			leftArrow=document.createElement('DIV');
			leftArrow.className='leftArrow';
			leftArrow.onclick=prevImageHandler;
			leftArrow.style.display='none';
			leftArrow.style.top=(kWindow.clientHeight()-leftArrow.offsetHeight)/2+'px';
			container.appendChild(leftArrow);
			}

		checkArrows();
		}
	this.open=open;

	var onImageLoadsHandler=function() {
		bkg.className='bkg';
		this.removeAttribute("width");
		this.removeAttribute("height");
		leftArrowWidth=leftArrow?parseInt(leftArrow.getAttribute("bkupwidth")):0;
		if(this.width>container.offsetWidth-20-leftArrowWidth*2) {
			var w=container.offsetWidth-20-parseInt(leftArrow?parseInt(leftArrow.getAttribute("bkupwidth")):0)*2;
			this.height=Math.round(w/this.width*this.height);
			this.width=Math.round(w);
			}
		if(this.height>container.offsetHeight) {
			var h=container.offsetHeight-20;
			this.width=Math.round(h/this.height*this.width);
			this.height=Math.round(h);
			}
		msg.style.top=((kWindow.clientHeight()-msg.offsetHeight)/2)+'px';
		if(parseInt(msg.style.left)<0) msg.style.left=(kWindow.clientWidth()+100)+'px';
		else msg.style.left=(-msg.offsetHeight-100)+'px';
		var title=link.getAttribute('title');
		caption.innerHTML=title;
		caption.style.opacity=(!title||title==""?0:1);
		move(msg,(kWindow.clientWidth()-msg.offsetWidth)/2,(kWindow.clientHeight()-msg.offsetHeight)/2,20,1,"Out",checkArrows);
		checkArrows();
		}
	var close=function() {
		move(msg,(-msg.offsetWidth-10),(kWindow.clientHeight()-msg.offsetHeight)/2,20,1,"In");
		setTimeout(hideBkg,500);
		setTimeout(closeIPopUp,1500);
		document.body.removeEventListener("keydown",keyDownHandler,false);
		}
	var hideBkg=function() {
		bkg.style.opacity=0;
		caption.style.opacity=0;
		}
	var closeIPopUp=function() {
		if(container) container.parentNode.removeChild(container);
		}
	var prevImageHandler=function() {
		var rel=link.rel.substr(10).replace("]","");
		var sel=getCurrentImageId();
		if(move&&!kIsMoving&&elements[rel][sel-1]) {
			caption.style.opacity=0;
			move(msg,(kWindow.clientWidth()+10),(kWindow.clientHeight()-msg.offsetHeight)/2,20,1,"In",openPrev);
			}
		}
	var openPrev=function() {
		bkg.className='bkg loading';
		var rel=link.rel.substr(10).replace("]","");
		var sel=getCurrentImageId();
		link=elements[rel][sel-1];
		img.src=elements[rel][sel-1].href;
		}
	var nextImageHandler=function() {
		var rel=link.rel.substr(10).replace("]","");
		var sel=getCurrentImageId();
		if(move&&!kIsMoving&&elements[rel][sel+1]) {
			caption.style.opacity=0;
			move(msg,(-msg.offsetWidth-10),(kWindow.clientHeight()-msg.offsetHeight)/2,20,1,"In",openNext);
			}
		}
	var openNext=function() {
		bkg.className='bkg loading';
		var rel=link.rel.substr(10).replace("]","");
		var sel=getCurrentImageId();
		link=elements[rel][sel+1];
		img.src=elements[rel][sel+1].href;
		}
	var getCurrentImageId=function() {
		var rel=link.rel.substr(10).replace("]","");
		if(!elements[rel]) return false;
		for(var i=0;elements[rel][i];i++) {
			if(elements[rel][i]==link) return i;
			}
		}
	var checkArrows=function() {
		var rel=link.rel.substr(10).replace("]","");
		var sel=getCurrentImageId();
		if(leftArrow) leftArrow.style.display=sel>0?'block':'none';
		if(rightArrow) rightArrow.style.display=sel<elements[rel].length-1?'block':'none';
		}
	var keyDownHandler=function(e) {
		if(e.keyCode==37) prevImageHandler();
		else if(e.keyCode==39) nextImageHandler();
		}

	var kIsMoving=false;
	var kOnMoveStop=function() {};
	function move(obj,toX,toY,steps,actualstep,ease,onstop) {
		kIsMoving=true;
		var pwr=3;
		obj.style.position='absolute';
		if(!onstop) onstop=function() {};
		if(!actualstep) actualstep=1;
		if(!ease) ease='InOut';
		if(actualstep==1) {
			if(obj.offsetLeft-toX!=0) {
				obj.setAttribute('startingX',obj.offsetLeft);
				var stepsX=Array();
				for(var i=1;i<=steps;i++) {
					if(ease=='InOut') stepsX[stepsX.length]=easeInOut(toX-obj.offsetLeft,steps,i,pwr);
					else if(ease=='In') stepsX[stepsX.length]=easeIn(toX-obj.offsetLeft,steps,i,pwr);
					else if(ease=='Out') stepsX[stepsX.length]=easeOut(toX-obj.offsetLeft,steps,i,pwr);
					}
				obj.setAttribute('easeStepsX',stepsX.join(','));
				}
			if(obj.offsetTop-toY!=0) {
				obj.setAttribute('startingY',obj.offsetTop);
				var stepsY=Array();
				for(var i=1;i<=steps;i++) {
					if(ease=='InOut') stepsY[stepsY.length]=easeInOut(toY-obj.offsetTop,steps,i,pwr);
					else if(ease=='In') stepsY[stepsY.length]=easeIn(toY-obj.offsetTop,steps,i,pwr);
					else if(ease=='Out') stepsY[stepsY.length]=easeOut(toY-obj.offsetTop,steps,i,pwr);
					}
				obj.setAttribute('easeStepsY',stepsY.join(','));
				}
			}
		if(obj.offsetLeft-toX!=0) {
			var step=obj.getAttribute('easeStepsX').split(',');
			var from=obj.getAttribute('startingX');
			obj.style.left=(parseInt(from)+parseInt(step[actualstep]))+'px';
			}
		if(obj.offsetTop-toY!=0) {
			var step=obj.getAttribute('easeStepsY').split(',');
			var from=obj.getAttribute('startingY');
			obj.style.top=(parseInt(from)+parseInt(step[actualstep]))+'px';
			}
		actualstep++;
		if(actualstep<steps&&kIsMoving==true) setTimeout(function() { move(obj,toX,toY,steps,actualstep,ease,onstop); },50);
		else {
			kIsMoving=false;
			obj.removeAttribute('startingX');
			obj.removeAttribute('startingY');
			obj.removeAttribute('easeStepsX');
			obj.removeAttribute('easeStepsY');
			onstop();
			}
		}

	}
function kLightbuzzInit() {
	var kLightbuzzTmp=new kLightbuzz;
	kLightbuzzTmp.init();
	}
kAddEvent(window,"load",kLightbuzzInit);
