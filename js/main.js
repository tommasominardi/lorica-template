/* (c) Kalamun.org - GNU/GPL 3 */

kAddEvent=function(obj,event,func,model) {
	if(!model) model=true;
	if(obj.addEventListener) return obj.addEventListener(event,func,model);
	if(obj.attachEvent) return obj.attachEvent('on'+event,func);
	return false;
	}
kGetPosition=function(obj) {
	var pos=Array();
	pos['left']=0;
	pos['top']=0;
	if(obj) {
		while(obj.offsetParent) {
			pos['left']+=obj.offsetLeft-obj.scrollLeft;
			pos['top']+=obj.offsetTop-obj.scrollTop;
			var tmp=obj.parentNode;
			while(tmp!=obj.offsetParent) {
				pos['left']-=tmp.scrollLeft;
				pos['top']-=tmp.scrollTop;
				tmp=tmp.parentNode;
				}
			obj=obj.offsetParent;
			}
		pos['left']+=obj.offsetLeft;
		pos['top']+=obj.offsetTop;
		}
	return {x:pos['left'],y:pos['top']};
	}

kWindow=new function() {
	this.filterResults=function(win,docel,body) {
		var result=win?win:0;
		if(docel&&(!result||(result>docel))) result=docel;
		return body&&(!result||(result>body))?body:result;
		}

	// size
	this.clientWidth=function() {
		return this.filterResults(window.innerWidth?window.innerWidth:0,document.documentElement?document.documentElement.clientWidth:0,document.body?document.body.clientWidth:0);
		}
	this.clientHeight=function() {
		return this.filterResults(window.innerHeight?window.innerHeight:0,document.documentElement?document.documentElement.clientHeight:0,document.body?document.body.clientHeight:0);
		}
	this.pageWidth=function() {
		if(window.innerHeight&&window.scrollMaxY) ww=window.innerWidth+window.scrollMaxX; //FF
		else if(document.body.scrollHeight>document.body.offsetHeight) ww=document.body.scrollWidth; //all but IE Mac
		else ww=document.body.offsetWidth; //IE 6 Strict, Mozilla (not FF), Safari
		return ww;
		}
	this.pageHeight=function() {
		if(window.innerHeight&&window.scrollMaxY) yy=window.innerHeight+window.scrollMaxY; //FF
		else if(document.body.scrollHeight>document.body.offsetHeight) yy=document.body.scrollHeight; //all but IE Mac
		else yy=document.body.offsetHeight; //IE 6 Strict, Mozilla (not FF), Safari
		return yy;
		}

	// scroll
	this.scrollLeft=function() {
		return this.filterResults(window.pageXOffset?window.pageXOffset:0,document.documentElement?document.documentElement.scrollLeft:0,document.body?document.body.scrollLeft:0);
		}
	this.scrollTop=function() {
		return this.filterResults(window.pageYOffset?window.pageYOffset:0,document.documentElement?document.documentElement.scrollTop:0,document.body ? document.body.scrollTop:0);
		}

	// mouse
	this.mousePos={x:0,y:0};
	this.elementOver=null;
	}


/* AJAX */
kAjax=function() {
	var onSuccess=function(txt) {};;
	var onFail=function(txt) {};;
	var ajaxObj=null;
	var method="get";
	var uri="";
	var vars="";

	this.send=function(vmethod,vuri,vvars) {
		method=vmethod.toLowerCase();
		uri=vuri;
		vars=vvars;
		ajaxSend();
		}
	this.onSuccess=function(func) { onSuccess=func }
	this.onFail=function(func) { onFail=func; }

	function createXMLHttpRequest() {
		var XHR=null;
		if(typeof(XMLHttpRequest)==="function"||typeof(XMLHttpRequest)==="object") XHR=new XMLHttpRequest(); //browser standard
		return XHR;
		}
	function onStateChange() {
		if(ajaxObj.readyState===4) {
			if(ajaxObj.status==200) onSuccess(ajaxObj.responseText,ajaxObj.responseXML);
			else onFail(ajaxObj.status);
			}
		}
	function ajaxSend() {
		ajaxObj=createXMLHttpRequest();
		if(method=="get") {
			uri+="?"+vars;
			ajaxObj.open(method,uri,true);
			ajaxObj.onreadystatechange=onStateChange;
			ajaxObj.send(null);
			}
		else if(method=="post") {
			ajaxObj.open(method,uri,true);
			ajaxObj.setRequestHeader("content-type","application/x-www-form-urlencoded");
			ajaxObj.onreadystatechange=onStateChange;
			ajaxObj.send(vars);
			}
		delete ajaxObj;
		}	
	}


function easeIn(value,totalSteps,actualStep,pwr) { 
	totalSteps=Math.max(totalSteps,actualStep,1);
	var step=Math.pow(((1/totalSteps)*actualStep),pwr)*(value);
	return Math.ceil(step);
	}
function easeOut(value,totalSteps,actualStep,pwr) { 
	totalSteps=Math.max(totalSteps,actualStep,1);
	var step=value-(Math.pow(((1/totalSteps)*(totalSteps-actualStep)),pwr)*(value));
	return Math.ceil(step);
	}
function easeInOut(value,totalSteps,actualStep,pwr) { 
	totalSteps=Math.max(totalSteps,actualStep,1);
	var p1=Math.ceil(totalSteps/2);
	var p2=totalSteps-p1;
	var p1a=Math.min(actualStep,p1);
	var p2a=actualStep-p1a;
	var step=Math.pow(((1/p1)*p1a),pwr)*(value/2);
	if(p2a>0) step+=value/2-(Math.pow(((1/p2)*(p2-p2a)),pwr)*(value/2));
	return Math.ceil(step);
	}


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


kPageGallery=function() {
	var container=null,
		imagebrowser,
		images=Array(),
		imagedivs=Array(),
		pager=null,
		pagerdivs=Array(),
		timer=null,
		lastLoadedImage=-1,
		currentImage=0;
	
	var init=function(c) {
		container=c;

		// convert all images to divs
		for(var i=0, img=container.getElementsByTagName('A'); img[i]; i++)
		{
			addImage(img[i].href);
		}

		container.innerHTML="";
		pager=document.createElement('DIV');
		pager.className='pager';
		container.appendChild(pager);
		loadAnotherImage();
		}
	this.init=init;
	
	var addImage=function(url) {
		images[images.length]=url;
		}
	this.addImage=addImage;
	
	var loadAnotherImage=function(id) {
		id=++lastLoadedImage;
		if(images[id]) {
			var img=document.createElement('IMG');
			img.src=images[id];
			img.onload=placeImage;
			img.id='pGimg'+id;
			}
		}
	this.loadAnotherImage=loadAnotherImage;

	var placeImage=function() {
		imagedivs[lastLoadedImage]=document.createElement('DIV');
		imagedivs[lastLoadedImage].style.backgroundImage="url('"+(images[lastLoadedImage])+"')";
		container.appendChild(imagedivs[lastLoadedImage]);
		pagerdivs[lastLoadedImage]=document.createElement('DIV');
		pagerdivs[lastLoadedImage].setAttribute('intid',lastLoadedImage);
		kAddEvent(pagerdivs[lastLoadedImage],"click",goTo);
		pager.appendChild(pagerdivs[lastLoadedImage]);
		if(images.length>1&&lastLoadedImage==0) play();
		else showCurrentImage();
		loadAnotherImage();
		}
	this.placeImage=placeImage;


	var play=function(dir) {
		timer=setInterval(next,4000);
		showCurrentImage();
	}
	
	var pause=function(dir) {
		clearInterval(timer);
	}
	
	var goTo=function(e,id) {
		if(!id) id=parseInt(this.getAttribute("intid"));
		pause();
		currentImage=id;
		play();
	}
	this.goTo=goTo;

	var next=function() {
		currentImage++;
		if(currentImage>imagedivs.length-1) currentImage=0;
		showCurrentImage();
		}
	
	var showCurrentImage=function() {
		for(var i=0;imagedivs[i];i++) {
			imagedivs[i].className="";
			pagerdivs[i].className="";
		}
		imagedivs[currentImage].className="current";
		pagerdivs[currentImage].className="current";
	}

}

function kInitSlideShow()
{
	if(document.getElementById('kSlideShow'))
	{
		var s = new kPageGallery()
		s.init(document.getElementById('kSlideShow'));
	}
}

function kScrollY()
{
	var supportPageOffset = window.pageXOffset !== undefined;
	var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");
	var y = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
	return y;
}
function kScrollTo(to, callback) {
	if(typeof(to) == "object") to = kGetPosition(to).top;
	if(to > document.body.scrollHeight - document.body.offsetHeight) to = document.body.scrollHeight - document.body.offsetHeight;
	if(!callback) var callback = function() {};

	var duration = 1000,
		start = null,
		from = kScrollY();

	var easeInOutCubic=function (t)
	{
		return Math.ceil((t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1)*1000)/1000;
	}

    function scroll(timestamp) {
		if(!start) start = timestamp;

		if(timestamp-start > duration)
		{
			callback();
			return;
		}
		
		var movement = (to - from) * easeInOutCubic(1/duration*(timestamp-start));
		window.scrollTo(0, from + movement);

		requestAnimationFrame(scroll);
    }

    requestAnimationFrame(scroll);
}

function onScrollHandler()
{
	var header=document.getElementById('topstripe');
	header.className = (kWindow.scrollTop()>header.offsetHeight ? 'onScroll' : '');

	var goToTop = document.getElementById('goToTop');
	if(!goToTop) return false;
	goToTop.className = (kScrollY()>10 ? 'visible' : '');
}

function onLoadHandler()
{
	var links=document.getElementsByTagName('A');
	for(var i=0; links[i]; i++)
	{
		if(links[i].className.indexOf('popup')>-1) kAddEvent(links[i],"click",popupLink);
	}
}

function popupLink(e)
{
	e.preventDefault();
	var w=400;
	var h=300;
	var title='';
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(this.href, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

kAddEvent(window,"scroll",onScrollHandler);
kAddEvent(window,"load",onLoadHandler);
kAddEvent(window,"load",kInitSlideShow);


// cookie law
function checkCookieLaw()
{
	var approved = false;
	for(var i=0, c=document.cookie.split(';'); c[i]; i++)
	{
		if(c[i].trim().indexOf("cookieLawApproved") == 0) approved = true;
	}
	
	if(approved==false)
	{
		var container = document.createElement('DIV');
		container.id = "cookieLawAlert";
		container.innerHTML = 'Questo sito utilizza cookie, anche di terzi, per migliorare la navigazione e raccogliere informazioni sull’uso del sito stesso.<br> Proseguendo si acconsente ai cookie. <a href="/privacy-cookie-policy">leggi come utilizziamo i dati</a>. <span id="cookieLawConfirm">ACCETTA</span> <span id="cookieLawClose"></span>';
		document.body.appendChild(container);
		
		kAddEvent(document.getElementById('cookieLawConfirm'), "click", confirmCookieLaw);
		kAddEvent(document.getElementById('cookieLawClose'), "click", confirmCookieLaw);
		kAddEvent(window, "scroll", confirmCookieLaw);
	}
}
function confirmCookieLaw(e)
{
	e.preventDefault();
	var alert = document.getElementById("cookieLawAlert");
	if(alert)
	{
		var d = new Date();
		d.setTime(d.getTime() + 2592000000);
		document.cookie = "cookieLawApproved=true; expires="+d.toUTCString()+"; path=/";
		alert.className = "hidden";
		setTimeout(function() { alert.parentNode.removeChild(alert); }, 1000);
	}
}
kAddEvent(window, "load", checkCookieLaw);



function onLoadHandler()
{
	var form = null;

	var onNewsletterSubscribe = function(e)
	{
		e.preventDefault();
		
		form = this;
		
		var vars = "";
		vars += "&nl_leaveEmpty=" + encodeURIComponent(this.nl_leaveEmpty.value);
		vars += "&nl_name=" + encodeURIComponent(this.nl_name.value);
		vars += "&nl_email=" + encodeURIComponent(this.nl_email.value);
		vars += "&nl_code=" + encodeURIComponent(this.nl_code.value);
		
		var loadingmessage = form.getElementsByClassName('nl_loading')[0];
		loadingmessage.className +=' show';
		
		var aj = new kAjax;
		aj.onSuccess(newsletterOK);
		aj.onFail(newsletterFAIL);
		aj.send("post", this.action, vars);
		
		return false;
	}
	
	var newsletterOK = function(html)
	{
		if(html=='1') newsletterOKmessage();
		else newsletterFailmessage();
	}

	var newsletterFAIL = function()
	{
		newsletterFailmessage();
	}
	
	var newsletterOKmessage = function()
	{
		var loadingmessage = form.getElementsByClassName('nl_loading')[0];
		var OKmessage = form.getElementsByClassName('nl_success')[0];
		var failmessage = form.getElementsByClassName('nl_fail')[0];
		
		loadingmessage.className = loadingmessage.className.replace(' show', '');
		OKmessage.className = OKmessage.className.replace(' show', '');
		failmessage.className = failmessage.className.replace(' show', '');

		OKmessage.className += ' show';
	}

	var newsletterFailmessage = function()
	{
		var loadingmessage = form.getElementsByClassName('nl_loading')[0];
		var OKmessage = form.getElementsByClassName('nl_success')[0];
		var failmessage = form.getElementsByClassName('nl_fail')[0];
		
		loadingmessage.className = loadingmessage.className.replace(' show', '');
		OKmessage.className = OKmessage.className.replace(' show', '');
		failmessage.className = failmessage.className.replace(' show', '');

		failmessage.className += ' show';
	}

	for(var i=0, c=document.querySelectorAll('.newsletter.subscribe'); c[i]; i++)
	{
		var form = c[i].getElementsByTagName('FORM')[0];
		kAddEvent(form, "submit", onNewsletterSubscribe);
	}
	
	if(document.getElementById('idsitem'))
	{
		shop = new kShopItem();
		shop.init();
	}
	shopCart = new kShopCart();
	shopCart.refreshPayments();
}
kAddEvent(window, "load", onLoadHandler);


function kShopItem()
{
	var priceElm=null;
	var itemID=null;
	var addToCartElm=null;
	var handler=TEMPLATEDIR+"ajax/shopHandler.php";
	
	var init=function() {
		itemID=document.getElementById('idsitem').value||null;
		priceElm=document.getElementById('price')||null;

		addToCartElm=document.getElementById('addToCart')||null;
		if(addToCartElm) kAddEvent(addToCartElm,'click',addToCart);

		for(var i=0;document.getElementById('variation'+i);i++) {
			kAddEvent(document.getElementById('variation'+i),'change',recalculatePrice);
			}
		recalculatePrice();
		}
	this.init=init;

	var recalculatePrice=function()
	{
		if(priceElm)
		{
			priceElm.innerHTML='...';
		
			//collect variations
			var variations=",";
			for(var i=0;document.getElementById('variation'+i);i++) {
				var v=document.getElementById('variation'+i);
				if(v.value!="") variations+=v.value+",";
				}

			//request price
			var aj=new kAjax();
			aj.onSuccess(printPrice);
			aj.onFail(printPriceError);
			aj.send("get",handler,"getItemPrice="+itemID+"&variations="+variations);
		}
	}
	this.recalculatePrice=recalculatePrice;

	var printPrice=function(html,xml) {
		if(priceElm) priceElm.innerHTML=html;
		}
	this.printPrice=printPrice;
	var printPriceError=function() {
		if(priceElm) priceElm.innerHTML='Error while loading data';
		}
	this.printPriceError=printPriceError;

	var addToCart=function () {
		if(addToCartElm)
		{
			//collect variations
			var variations=",";
			for(var i=0;document.getElementById('variation'+i);i++)
			{
				var v=document.getElementById('variation'+i);
				if(v.value!="") variations+=v.value+",";
			}

			var aj=new kAjax();
			aj.onSuccess(function()
			{
				printAddedToCart();
				shopCart.updateWidget();
			});
			aj.onFail();
			aj.send("post",handler,"addToCart="+itemID+"&variations="+variations);
			}
		}
	this.addToCart=addToCart;
	
	var printAddedToCart=function()
	{
		if(addToCartElm) addToCartElm.parentNode.className+=' added';
		setTimeout(hideAddedToCart,2000);
	}
	this.printAddedToCart=printAddedToCart;
	
	var hideAddedToCart=function()
	{
		if(addToCartElm) addToCartElm.parentNode.className=addToCartElm.parentNode.className.replace('added','');
	}
	this.hideAddedToCart=hideAddedToCart;
}

function kShopCart() {
	var handler=TEMPLATEDIR+"ajax/shopHandler.php";

	var init=function() {
		refreshPayments();
		}
	this.init=init;
	
	var addToCart=function(uid) {
		var aj=new kAjax();
		aj.onSuccess(function(html,xml) {
			updateWidget(html,xml);
			});
		aj.onFail();
		aj.send("post",handler,"increaseCartItem="+uid);
		}
	this.addToCart=addToCart;

	var removeFromCart=function(uid) {
		var aj=new kAjax();
		aj.onSuccess(function(html,xml) {
			updateWidget(html,xml);
			});
		aj.onFail();
		aj.send("post",handler,"decreaseCartItem="+uid);
		}
	this.removeFromCart=removeFromCart;

	var updateWidget = function(html,xml)
	{
		var containers = document.getElementsByClassName('cartWidget');
		if(containers.length>0)
		{
			var aj = new kAjax();
			aj.onSuccess(printWidget);
			aj.onFail();
			aj.send("post",handler,"getCartSummary=true");
		}
	}
	this.updateWidget=updateWidget;
	
	var printWidget=function(html,xml)
	{
		var containers = document.getElementsByClassName('cartWidget');
		for(var i=0; containers[i]; i++)
		{
			html = html.replace(/<section .*?>/,"");
			html = html.replace("</section>","");
			containers[i].innerHTML = html;
		}
	}

	var updateItemQuantity=function(html,xml) {
		var items = html.split("\n");
		for(var i in items) {
			var attr=items[i].split("|");
			if(attr[0]!='tot') {
				var tr=document.getElementById('item'+attr[3]);
				if(tr) {
					if(parseInt(attr[1])==0)
					{
						tr.parentNode.removeChild(tr,true);
					} else {
						if(tr.querySelector('.qtynum')) tr.querySelector('.qtynum').innerHTML=attr[1];
						if(tr.querySelector('.pricenum')) tr.querySelector('.pricenum').innerHTML=attr[2];
					}
				}
			} else {
				document.querySelector('.totalnum').innerHTML=attr[2];
			}
		}
	}
	this.updateItemQuantity=updateItemQuantity;
	
	var switchVisibility=function(elm) {
		if(elm.offsetHeight<20) {
			elm.style.height=elm.scrollHeight+'px';
			elm.getElementsByTagName('INPUT')[0].value='yes';
			}
		else {
			elm.style.height=0;
			elm.getElementsByTagName('INPUT')[0].value='no';
			}
		}
	this.switchVisibility=switchVisibility;
	
	var refreshPayments=function()
	{
		var cnt=document.getElementById('paymentMethods');
		if(!cnt) return false;
		var country="";
		if(document.getElementById('delivery_country')) country=document.getElementById('delivery_country').value;
		if(country=="" && document.getElementById('customer_country')) country=document.getElementById('customer_country').value;
		
		if(document.getElementById('delivery_country')) kAddEvent(document.getElementById('delivery_country'),'change',refreshPayments);
		if(document.getElementById('customer_country')) kAddEvent(document.getElementById('customer_country'),'change',refreshPayments);
		
		var ajax=new kAjax();
		ajax.onSuccess(function(html,xml)
			{
				document.getElementById('paymentMethods').innerHTML=html;
			});
		ajax.onFail(function(error) { });
		ajax.send("get",handler,"&getPaymentsByCountryCode="+escape(country));
	}
	this.refreshPayments=refreshPayments;

}
