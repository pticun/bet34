var afterLoad = require('after-load');
var cheerio = require('cheerio');

var utils = require('./utils.js');

var game_id = process.argv[2];

var html=afterLoad('https://www.flashresultats.fr/match/' + game_id);
const $ = cheerio.load(html);

console.log(JSON.stringify(utils.get_game_data($, game_id)));
