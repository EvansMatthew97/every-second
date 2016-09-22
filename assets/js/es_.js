var SHOW_TIME = 2.5;

function gi(e) {
	return document.getElementById(e);
}
function gc(e) {
	return document.getElementsByClassName(e);
}

function http(url, callback) {
	var x = new XMLHttpRequest();
	
	x.addEventListener('readystatechange', function(e) {
		if (x.readyState == 4) {
			callback(x.responseText);
		}
	});

	x.open('GET', url, true);
	x.send();
}

function setTimer(timer, time) {
	if (timer.getAttribute('class').indexOf('et--as') == -1) {
		time = parseFloat(time);
		var rt = time - SHOW_TIME;
		
		timer.setAttribute('class', 'et');

		var b = timer.firstChild;

		var em = b.firstChild;
		em.style.width = 0;
		em.style.height = 0;
		//em.style.opacity = 0;

		var im = b.lastChild;
		im.style.width = 0;
		im.style.height = 0;
		im.style.opacity = 0;

		var ms = new Date().getTime();

		var isAnimating = true;

		function c(s) {
			s = Math.min(100, s);
			return s + '%';
		}
		
		var anim = setInterval(function() {
			if (!isAnimating) {
				clearInterval(anim);
			}
			var sec = (new Date().getTime() - ms) / 1000;

			var s = Math.max(0, (sec / rt * 100 * 4));
			em.style.width = c(s);
			em.style.height = c(s - 100);
			
			if (s - 200 > 0) {
				im.style.opacity = 1;
			}
			im.style.width = c(s - 200);
			im.style.height = c(s - 300);

		}, 1 / 60);

		setTimeout(function() {
			isAnimating = false;
			timer.setAttribute('class', 'et et--s');
			setTimeout(function() {
				isAnimating = true;
				setTimer(timer, time);
			}, SHOW_TIME * 1000);
		}, rt * 1000);
	}
}

(function() {
	var timers = gc('et');

	for (var i = 0; i < timers.length; i++) {
		var timer = timers[i];

		setTimer(timer, timer.getAttribute('e'));
	}
})();


function addLinkEventListener(link) {
	link.addEventListener('click', function(e) {
		e.preventDefault();
		var m = gi('m');
		var mBody = gi('m_body');
		var mTitle = gi('m_title');
		var mHeader = gi('m_header');

		var titleNode = link.parentNode.getElementsByClassName('et__t')[0];
		var title = titleNode.innerHTML;

		m.setAttribute('class', 'm-c m-c--s');
		mBody.innerHTML = '<p>Loading...</p>';
		mTitle.innerHTML = title;

		gi('page').setAttribute('style', 'overflow-y: hidden;');

		mHeader.setAttribute('style', link.parentNode.getElementsByClassName('et__bg')[0].getAttribute('style'));
		
		http(link.getAttribute('href'), function(data) {
			mBody.innerHTML = data;
		});
	});
}

function hidem(m) {
	gi('page').setAttribute('style', 'overflow-y: scroll;');
	m.setAttribute('class', 'm-c');

}

(function() {
	var links = gc('et__l');
	for (var i = 0; i < links.length; i++) {
		var link = links[i];

		link.setAttribute('href', 'page.php' + link.getAttribute('href'))

		addLinkEventListener(link);
	}

	var m = gi('m');
	m.setAttribute('style', 'display: block;');

	var bg = gi('m_bg');
	var m = gi('m');
	bg.addEventListener('click', function() {
		hidem(m);
	});

	var mClose = gi('m_close');
	mClose.addEventListener('click', function(e) {
		e.preventDefault();
		hidem(m);
	});
})();