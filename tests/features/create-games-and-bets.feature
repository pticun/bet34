@betting

Feature: Create bet during game


  Scenario: Create games and bets
     When I run "app:games:foot:live" command
     Then the "game" with "unibet_id" "1222543_1" should have "name" equal to "Alaves - Athletic Bilbao"
     Then the "game" with "unibet_id" "1222543_1" should have "sport" equal to "Football"
     Then the "game" with "unibet_id" "1222543_1" should have "home_team_name" equal to "Alaves"
     Then the "game" with "unibet_id" "1222543_1" should have "away_team_name" equal to "Athletic Bilbao"
     Then the "game" with "unibet_id" "1222543_1" should have "is_live" equal to "1"
     Then the "game" with "unibet_id" "1222543_1" should have "url" equal to "/live/football/event-focus/alaves-athletic-bilbao-1222543_1.html"
     Then the "game" with "unibet_id" "1222543_1" should have "home_score" equal to "0"
     Then the "game" with "unibet_id" "1222543_1" should have "away_score" equal to "0"
     Then the "game" with "unibet_id" "1222543_1" should have "chrono" equal to "32"
     Then the "game" with "unibet_id" "1222543_1" should have "period" equal to "MT 1"
     Then the last "bet" should have "market_name" equal to "Résultat du match"
     Then the last "bet" should have "home_selection_name" equal to "Alaves"
     Then the last "bet" should have "home_rate" equal to "2.95"
     Then the last "bet" should have "away_selection_name" equal to "Athletic Bilbao"
     Then the last "bet" should have "away_rate" equal to "2.15"
     Then the last "bet" should have "draw_rate" equal to "2.65"
     Then the last "bet" should have "home_score" equal to "0"
     Then the last "bet" should have "away_score" equal to "0"
     Then the last "bet" should have "chrono" equal to "32"
     Then the last "bet" should have "period" equal to "MT 1"
