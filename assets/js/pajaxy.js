;(function($w, $d){
	"use strict"

	var ArPro 	= Array.prototype;
	var SrPro 	= String.prototype;

	var extend = function(exObj, newObj){
		Object.assign(exObj, newObj);
	}

	/*=======================================
	=            Utilities class            =
	=======================================*/

	extend(ArPro, {
		each: function(callback){
			$w.each(this, callback);
		},
		count: function(callback){
			return this.length;
		},
		exists: function(value){
			return this.indexOf(value) > -1;
		},
		in: function(value){
			return this.exists(value);
		}
	});


	extend(SrPro, {
		trim_str: function (c) {
		  	var re = new RegExp("^[" + c + "]+|[" + c + "]+$", "g");
		 	 return this.replace(re,"");
		},
		toDom: function() {
		    var t = $d.createElement('template');
		    t.innerHTML = this;
		    return t.content.childNodes;
		}
	});



	extend($w, {
		object_key_exists: function(key, obj){
			return obj.hasOwnProperty(key);
		},
		log: function(l){
			console.log(l);
		},
		error: function(l){
			console.error(l);
		},
		is_type: function(o, type){
			return typeof o == type ? true : false;
		},
		isset: function(o){
			return is_type(o, "undefined") ? false : true;
		},
		is_callable: function(o){
			return is_type(o, "function");
		},
		is_object: function(o){
			return is_type(o, "object");
		},
		is_array: function(o){
			return Array.isArray(o);
		},
		is_string: function(str){
			return is_type(str, "string");
		},
		is_number: function(n){
			return is_type(n, "number");
		},
		in_array: function(arr, value){
			return arr.exists(value);
		},
		random_str: function(limit = 5){
			return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, limit);
		},
		parse_url: function(url){
			
			var p 	= $d.createElement('a');
			p.href = url;

			var qo = {} ,sq, sp;
			sq = p.search.trim_str('?');
			sp = sq.split('&');
			if (sp.length) {
				for(var q of sp){
					var s = q.split('=');
					if (s[0]) {
						qo[s[0]] = s[1];
					}
				}
			}
			
			var search = '', e = encodeURIComponent;
		    for (name in qo) {
		        search += '&' + name + '=' + qo[name];
		    }
		    search = search.trim_str('&');
			var format = {
				href: (p.pathname+"?"+search+p.hash).trim_str("?"),
				protocol: p.protocol,
				host: p.host,    
				hostname: p.hostname,
				port: p.port,    
				pathname: p.pathname,
				hash: p.hash,    
				search: search, 
				query_object: qo, 
				origin: p.origin,
				urlpath: p.pathname+p.search,
				key: hash(p.pathname+p.search)
			}
			return format;
		},
		hash:function(s){
		  return s.split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0);              
		},
		serialize: function(data){
			var y = '', e = encodeURIComponent;
		    for (x of data) {
		        y += '&' + e(x.name) + '=' + e(x.value);
		    }
		    data = y.slice(1);
		    return data;
		},
		each: function(ob, callback){
			if (is_array(ob)) {
				for(var inx = 0; inx < ob.length; inx++){
					if(callback(ob[inx], inx) === true){
						break;
					}
				}
			}else if(is_object(ob)){
				for(var inx in ob){
					if (inx == 'each') {
						continue;
					}

					var call = callback(ob[inx], inx);
					if(call === 'break'){
						break;
					}else if(call === 'continue'){
						continue;
					}
				}
			}
		}
	})






	/**
	 * Pajaxy Start
	 */


	var IS_POPSTATE = false;
	var PAJAXY_LOCAL = {
		action: []
	}
	$w.pajaxy = {
		load_page: function(path){
			request(path);
		},
		remove_cache: function(path){
			var url = parse_url(path);
			Cache.delete(url.key);
		},
		action: function(cb){
			if (is_callable(cb)) {
				PAJAXY_LOCAL.action.push(cb);
			}
		},
		initOfContent: function(data){
			// pajaxy inut for this data only
			return init(data);
		}
	};

	/*====================================
	=            Cache Object            =
	====================================*/
	var ct = PREFIX+"_cached";
	$w[ct] = $w[ct] || [];

	var Cache = {
		is: function(key){
			return  isset($w[ct][key]) ? true : false;
		},
		set: function(key, value){
			$w[ct][key] = value;
		},
		get: function(key){
			if (Cache.is(key)) {
				return $w[ct][key]
			}
		},
		delete: function(key){
			if (Cache.is(key)) {
				delete $w[ct][key];
			}
		},
		deleteAll: function(){
			$w[ct] = [];
		}
	}
	
	
	/*=====  End of Cache Object  ======*/
	var pref = PREFIX;
	var get = function(ob, name, def = null){
		var data = ob[name];
		return isset(data) ? data : def;
	}



	var render = function(res, setting){
		
		var url = parse_url(get(res, 'uri'));
		// change the url path
		if (!IS_POPSTATE) {
			$w.history.pushState({url:url.href}, null, url.href);
			$w.scrollTo(0,0);
		}else{
			IS_POPSTATE = false;
		}

		// delete all cache
		if (get(res, 'restore')) {
			Cache.deleteAll();
		}




		var scripts = get(res, 'scripts');
		// set css
		$.each(scripts.css, function(name, item){
			var src = item.src;
			src = src.replace('?v='+CACHE_VARSION);
			if (!$('link.'+name).length) {
				var st = $('<link />');
				st.attr('class', PREFIX+' '+name);
				st.attr('type', 'text/css');
				st.attr('rel', 'stylesheet');
				st.attr('href', src);
				if(!item.footer){
					$('head').append(st);
				}else{
					$('body').append(st);
				}
			}
		});



		// set js
		var footer_js = [];

		for(var name in scripts.js){
			var item = scripts.js[name];
			var src = item.src;
			if (!$('script.'+name).length) {
				var st = $('<script>');
				st.attr('class', PREFIX+' '+name);
				st.attr('type', 'text/javascript');
				st.attr('src', src);
				
				if(!item.footer){
					$('head').append(st);
				}else{
					footer_js.push(sr);
				}
			}
		}

		// content
		var replace_only = $(setting.replace_only), replace_only_excuted = false;

		if (replace_only.length) {
			var wrapper = $('<div>');
			wrapper.append(get(res, 'content'));
			var block = wrapper.find(setting.replace_only);
			if (block) {
				replace_only.html(block.html());
				replace_only_excuted = true;
			}
		}

		if(!replace_only_excuted){
			$('head title').html(get(res, 'title'));
			$('head').append(get(res,'head'));
			$('body')
			.attr('class', get(res, 'bodyclass'))
			.html(get(res, 'content'));

			for(var fjs of footer_js){
				$('body').append(fjs);
			}
		}
		
		init();
	}

	var requested_keys = [];

	var request = function(setting){

		if (setting.url == '#') {
			return;
		}

		if (!DEV_MODE && !navigator.onLine) {
			alert('Check your internet connection');
			return;
		}

		var url = parse_url(setting.url);

		$.each(PAJAXY_LOCAL.action, function(idx, cb){
			cb({state: 'start'});
		});

		if (setting.cache_only && requested_keys.exists(url.key)) {
			return;
		}

		requested_keys.push(url.key);


		if (!setting.cache_only && Cache.is(url.key) && !setting.form) {
			$.each(PAJAXY_LOCAL.action, function(idx, cb){
				cb({state: 'load'});
			});
			return render(Cache.get(url.key), setting);
		}




		$.ajax({
			url: url.href,
			method: setting.method,
			data: setting.data,
			headers: {
				pajaxy: PAGE_TOKEN
			},

			success: function(res){

				var dataFormat = res[pref+'-data'];

				$.each(PAJAXY_LOCAL.action, function(idx, cb){
					cb({
						state: 'load',
						response: dataFormat 
					});
				});


				if (get(dataFormat, 'iscache') && !setting.form) {
					Cache.set(url.key, dataFormat);
				}
				if (!setting.cache_only) {
					render(dataFormat, setting);
				}

				// cache the extra pages
				$.each(get(dataFormat, 'docache', []), function(idx, path){
					var url = parse_url(path);
					request({
						url: path,
						cache_only: true,
					});
				});
				// delete the cache of an array url
				$.each(get(dataFormat, 'doclear', []), function(idx, path){
					var url = parse_url(path);
					Cache.delete(url.key);
				});

				$.each(PAJAXY_LOCAL.action, function(idx, cb){
					cb({state: 'finished'});
				});
			},
			error: function(){
				error("Pajaxy response Error");
			},
		});


	}

	var init = function(source = null){
		var px;
		if (source) {
			if (is_string(source)) {
				source = $(source);
				if (source.length > 1) {
					var wrapper = $('<div>');
					source = wrapper.append(source);
				}
				px = source.find('[pajaxy]');
			}else{
				error("Wrong data passing in initOfContent method! expect string dom");
				return;
			}

		}else{
			px = $('[pajaxy]');
		}

		px.each(function(){

			var ele = $(this);
			var tagName = ele.prop("tagName").toLowerCase();
			var changing_block = ele.attr('pajaxy');

			if (tagName === 'form') {
				ele.off().submit(function(e){
					e.preventDefault();
					var form = $(this);

					if (form.attr('confirm')) {
						if (!confirm(form.attr('confirm'))) {
							return false;
						}
					}

					var data = null;
					var submit_btn = form.find('[type=submit]');

					var file = form.find('[type=file]');
					if (file.length) {
						data = new FormData(this);
						if (submit_btn.length) {
							data.append(submit_btn.attr('name'), submit_btn.attr('value'));
						}
					}else{
						data = form.serializeArray();
						if (submit_btn.length) {
							data.push({ name: submit_btn.attr('name'), value: submit_btn.attr('value') });
						}
					}


					var url = form.attr('action') || $w.location.href;
					request({
						form: true,
						method: form.attr('method'),
						url: url,
						data: data,
						replace_only: changing_block, // if the value is exists then find the element with that value and change the block only
					});
				});
			}else if(tagName === 'a'){
				if (ele.attr('href')  != '#') {
					ele.off().click(function(e){
						e.preventDefault();
						var ancor = $(this);
						if (ancor.attr('confirm')) {
							if (!confirm(ancor.attr('confirm'))) {
								return false;
							}
						}

						request({
							method: ancor.attr('method'),
							url: ancor.attr('href'),
							replace_only: changing_block, // if the value is exists then find the element with that value and change the block only
						});
					});
					ele.removeAttr('method');
				}
			}
			ele.removeAttr('pajaxy');
		});


		if (is_object(source))  {
			return source;
		}else{
			return px;
		}
	}

	init();
	$(document).ready(function(){
		init();
	});

	$w.onpopstate = function (e) {
		e.preventDefault();
		IS_POPSTATE = true;
		if (e.state) {
			request({
				url: $w.location.href,
			});
		}
		
	}


})(window, document)