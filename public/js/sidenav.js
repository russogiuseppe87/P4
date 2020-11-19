// objet constructeur sidenavToggle
function sidenavToggle(){
	this.openButton = document.querySelector('.open-navigation i');
	this.closeButton = document.querySelector('.close-navigation i');
	this.navContainer = document.querySelector('.navigation');
	this.pageWrap = document.querySelector('.page-wrap');
  	this.mql = window.matchMedia("(max-width: 1130px)");

	this.init = function(){
		this.saveNavState();

		// Écrans larges 
      	if(!this.mql.matches){
      		this.rememberNavState();
      	}
 	},

 	this.saveNavState = function(){
 		window.onhashchange = function() { 
	 		let path = window.location.hash; 

	 		if (path === '#main-navigation'){
	 			// sessionStorage/localStorage ne fonctionne pas sur tous mobiles Ios
		    	document.cookie = "navState=open"; 
	 		}
	 		else {
	 			document.cookie = "navState=closed";
	 		}
	 		let navState = this.getCookie("navState")
		}.bind(this)
 	},

 	this.rememberNavState = function(){
 		let navState = this.getCookie("navState")
  		if (navState === 'open'){
  			// désactiver le comportement des transitions au chargement de la page
			this.navContainer.style.transition = 'initial';
			this.pageWrap.style.transition = 'initial';	
			// ouvrir le menu de navigation
  			location.hash = 'main-navigation';
  			// réactiver le comportement des transitions après chargement
      		this.navContainer.style.transition = 'width 0.3s ease';
			this.pageWrap.style.transition = 'width 0.3s ease';
  		}
 	},

 	this.getCookie = function(cname){
	  	var name = cname + "=";
	  	var decodedCookie = decodeURIComponent(document.cookie);
	  	var ca = decodedCookie.split(';');
	  	for(var i = 0; i <ca.length; i++) {
	    	var c = ca[i];
	    	while (c.charAt(0) == ' ') {
	      		c = c.substring(1);
	    	}
	    	if (c.indexOf(name) == 0) {
	      		return c.substring(name.length, c.length);
	    	}
	  	}
	  	return "";
	}

}

// objet constructeur sidenavMarker
function sidenavMarker(){
	this.menuTitlesElements = document.getElementsByClassName('menuTitle');
	this.currentUrl = window.location.href;
	
	this.init = function(){
		if (/index\.php/.test(this.currentUrl)) {
			let hashFreeCurrentUrl = this.currentUrl.replace(/#.+$/, "");

			Array.prototype.forEach.call(this.menuTitlesElements, function(element) {

				if (element.href === hashFreeCurrentUrl) { element.firstElementChild.style.display = 'initial';	 } 

			}.bind(this)); 		
		} 
		// Au premier chargement du site
		else { 
			this.menuTitlesElements[0].firstElementChild.style.display = 'initial';			
		}
 	}
}



var mySidenavToggle = new sidenavToggle();
mySidenavToggle.init();

var mySidenavMarker = new sidenavMarker();
mySidenavMarker.init();

