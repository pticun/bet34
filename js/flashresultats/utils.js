var moment = require('moment-timezone');
moment().tz("Europe/Paris").format();
var utils = {};

utils.isAliveGame = function($){
    return $('#atomclock').length > 0;
}

utils.isTerminated = function($){
    return (['Terminé', 'Après prolongation']).indexOf($('.mstat').text()) > -1;
}

utils.getTeamHomeName = function($){
    return $('.tname-home a').text();
}

utils.getTeamAwayName = function($){
    return $('.tname-away a').text();
}

utils.getTeamHomeRank = function($){
    if(utils.isAliveGame($)){
        return Math.abs($('#default-live-odds .o_1 .value span').text());
    }

    return Math.abs($('.o_1 .value span').text());
}

utils.getTeamAwayRank = function($){
    if(utils.isAliveGame($)){
        return Math.abs($('#default-live-odds .o_2 .value span').text());
    }
    return Math.abs($('.o_2 .value span').text());
}

utils.getDrawRank = function($){
    if(utils.isAliveGame($)){
        return Math.abs($('#default-live-odds .o_0 .value span').text());
    }
    return Math.abs($('.o_0 .value span').text());
}

utils.getGameDayToTimestamp = function($){
    var game_day = moment($('#utime').text(), "DD.MM.YYYY HH:mm");
    return game_day.unix();
}

utils.getTeamHomeScore = function($){
    return $($('#event_detail_current_result .scoreboard')['0']).text();
}

utils.getTeamAwayScore = function($){
    return $($('#event_detail_current_result .scoreboard')['1']).text();
}

utils.get_game_data = function($, game_id){
    var data = {
        game_id: game_id,
        team_home_name: utils.getTeamHomeName($),
        team_away_name: utils.getTeamAwayName($),
        team_home_rank: utils.getTeamHomeRank($),
        team_away_rank: utils.getTeamAwayRank($),
        draw_rank: utils.getDrawRank($),
        game_day: utils.getGameDayToTimestamp($),
        is_alive: utils.isAliveGame($),
        is_terminated: utils.isTerminated($)
    };

    if(data.is_terminated){
        data.team_home_score = utils.getTeamHomeScore($);
        data.team_away_score = utils.getTeamAwayScore($);
    }

    return data;
}

module.exports = utils;
