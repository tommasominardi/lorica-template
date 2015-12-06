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
}
kAddEvent(window, "load", onLoadHandler);

