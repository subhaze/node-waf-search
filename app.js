
/**
 * Module dependencies.
 */

var express = require('express');
var jade = require('jade');
var app = express.createServer();

app.use(app.router);
app.set('view engine', 'jade');

var request = require('request');
var packages = {};

request('http://registry.npmjs.org/-/scripts?scripts=install,preinstall,postinstall&match=\\bnode-waf\\b', function (error, response, body) {
	if (!error && response.statusCode == 200) {
		packages = JSON.parse(body);
	}
});

// update packages every hour...
setInterval(function(){
	request('http://registry.npmjs.org/-/scripts?scripts=install,preinstall,postinstall&match=\\bnode-waf\\b', function (error, response, body) {
		if (!error && response.statusCode == 200) {
			packages = JSON.parse(body);
		}
	});
}, 1000*60*60);

app.get('/', function(req, res){
	res.render('layout', { packages: packages });
});

app.listen(3000);
console.log('Express app started on port 3000');