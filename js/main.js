(function(){
  var nav=document.querySelector('.nav-links'),btn=document.querySelector('.menu-toggle');
  if(!nav||!btn)return;
  btn.addEventListener('click',function(){var o=nav.classList.toggle('open');btn.setAttribute('aria-expanded',o)});
  nav.querySelectorAll('a').forEach(function(a){a.addEventListener('click',function(){nav.classList.remove('open');btn.setAttribute('aria-expanded','false')})});
})();
