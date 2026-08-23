<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'template'   => 'simple_page',
            'name'       => 'The game',
            'title'      => 'The game',
            'slug'       => 'the-game',
            'content'    => '<h2>MAF RULES AND PHASES</h2>

<p><img alt="" src="http://mafportal.com/uploads/choose_maf.jpeg" style="float:left; height:474px; width:311px" /> Ten players participate in the game. The game is conducted at a Maf round table with seats numbered 1 through 10. The table also has a seat for the moderator who monitors the course of the game and regulates its stages. The moderator has assistants to help conduct and direct the game.</p>

<p>Prior to being seated at a table, each player pulls a card containing the seat number. There are no advantages or disadvantages associated with the number of the seat. The players are called by the number of their seat. For example, the player in seat 2 is called player number 2. When all players are seated at the table and greeted by the moderator, the game begins.</p>

<p>The game is divided into 2 phases: &quot;day&quot; and &quot;night.&quot; Each player has a personal mask, which is used to cover the eyes during the &quot;night.&quot; The moderator announces &quot;Day&quot; and &quot;night.&quot;</p>

<p>The games starts with a &quot;night&quot; and all players put on their masks. Then, one by one, each player is allowed to remove the mask and choose a card from a deck of 10 cards. The player seated under number 1, chooses first. When a card is chosen by a player, it is eliminated from the deck. Thus, when it is 2nd player&#39;s turn to choose, there are only 9 cards left in the deck, only 8 cards left for the 3rd player, 7 for the 4th player, and so on. After choosing the card, each player puts the mask back on, thus no player knows which cards were chosen by the other players.</p>

<p>There are 7 red (&quot;CITIZEN&quot;) and 3 black (&quot;MAF&quot;) cards in the deck. One of the 7 red cards differ from the others - it is the card &quot;SHERIFF&quot; - the leader of &quot;Reds.&quot; &quot;Blacks&quot; also have their leader - the card &quot;DON.&quot; Thus, the players are divided into two groups: Reds and Blacks. The object of the game is the elimination of the opposite team members.</p>

<p><img alt="" src="http://mafportal.com/uploads/night_maf.jpeg" style="float:right; height:350px; width:252px" />During the same &quot;night,&quot; when all the cards are chosen, the moderator announces, &quot;The Mafia awakens.&quot; Then, the players with black cards, including the Don, take off their masks and become acquainted with one another. This is the first and the only night that the mafia members open their eyes all at the same time. During this &quot;introduction,&quot; the black players can set up their plot for the elimination of red players. The &quot;discussion&quot; should be made quietly, so that the &quot;red&quot; players do not hear or feel anything. The black players have only 30 seconds for their &quot;communication.&quot; The moderator announces: &quot;The Mafia sleeps.&quot; After these words the &quot;black&quot; players put their masks back on.</p>

<p>The moderator announces, &quot;The Don awakens.&quot; Then, the Don takes off the mask and becomes acquainted with the moderator. On subsequent &quot;nights,&quot; the Don will wake up and look for the Sheriff. The moderator announces, &quot;The Don sleeps,&quot; and the Don puts the mask back on.</p>

<p>The moderator announces, &quot;The Sheriff awakens.&quot; Then, the Sheriff takes off the mask and becomes acquainted with the moderator. During subsequent nights, the Sheriff will wake up and search for &quot;black&quot; players. The moderator announces, &quot;The Sheriff sleeps&quot; and the Sheriff puts the mask back on. This concludes the first night.</p>

<p>The moderator announces, &quot;Morning. All wake up&quot; on the first day. All players take off their masks. During the &quot;day&quot; an open discussion takes place. The purpose of the discussions and the game as a whole for the &quot;reds&quot; is to bring to light and eliminate &quot;blacks,&quot; and for the &quot;blacks,&quot; - to confuse the other players and &quot;frame&quot; and eliminate the &quot;reds.&quot; &quot;Blacks&quot; have a considerable advantage in these discussions, since they know who is who in this game.</p>

<p>Each player has a minute to express ideas, thoughts and suspicions. The player in seat 1 begins the discussion on the first day and the rest of the players get their turn in order. During their 1-minute speeches, players may recommend the &quot;most suspicious&quot; candidate (no more than one candidate per speech) to be voted off the game. The number of candidates can range from 0 to 10 per &quot;day.&quot;</p>

<p>At the end of the discussion, when all players have expressed their &quot;ideas,&quot; the moderator announces the number of accepted candidates and voting takes place. Each player is allowed to vote only for one candidate. The voted-off player has the right to a last statement (no more than 1 minute) and must then leave the table.</p>

<p>A minimum of two candidates are required for voting during the first &quot;day.&quot; If only one candidate is recommended during the first &quot;day,&quot; no voting takes place, and the player remains in the game. This rule applies only to the first &quot;day.&quot; If only one candidate is recommended during subsequent &quot;days,&quot; no voting takes place, but the player is automatically voted-off.</p>

<p><img alt="" src="http://mafportal.com/uploads/vote_maf.jpeg" style="float:left; height:311px; width:328px" />If two or more players receive an equal of the greatest number of votes, further discussion takes place. In this case, the players with the most votes are allowed an additional 30-second speech in order to plead their case and ask not to be voted off. Then the second round of voting takes place with the choice to vote only for the candidates with the largest amount of votes. The voted-off player is still awarded a last statement (no more than 1 minute) and must then leave the table. In the event of a second draw in which candidates still receive the same amount of votes, the moderator requests all players to vote either to keep the candidates in the game or to vote them all off. If the majority votes for elimination, all candidates are considered voted-off and leave the table. If the majority is against it or the votes are divided, the candidates remain at the table.</p>

<p>When all the discussion is over, the moderator announces, &quot;Night,&quot; and all the players put their masks back on. During this and the following nights, the &quot;blacks&quot; have the opportunity to eliminate players by &quot;shooting&quot; them. &quot;Shooting&quot; takes place in the following way. The moderator announces, &quot;Mafia goes hunting,&quot; and each black player, with their mask on, indicates the number of the player they are shooting. If all members of Mafia &quot;shoot&quot; at the same player, that player is considered eliminated. If the Mafia members &quot;shoot&quot; at different players, they miss; it therefore it is imperative for the black players to plan the sequence of player elimination during the first night, when they all see each other. The moderator then announces, &quot;Mafia sleeps.&quot;</p>

<p><img alt="" src="http://mafportal.com/uploads/mod_maf.jpeg" style="float:right; height:289px; width:178px" />Next, the moderator announces, &quot;The Don awakens.&quot; The Don takes off the mask and is allowed to &quot;check&quot; one player per night. The Don indicates the number of the player, and the moderator silently indicates &quot;YES&quot; (the player IS the Sheriff), or &quot;NO&quot; (the player is NOT the Sheriff). Then the moderator announces, &quot;The Don sleeps,&quot; and the Don puts the mask back on.</p>

<p>Then the moderator announces, &quot;The Sheriff awakens.&quot; The Sheriff takes off the mask and allowed to &quot;check&quot; one player per night. The Sheriff indicates the number of the player, and the moderator silently indicates &quot;YES&quot; (the player IS a &quot;black&quot; player), or &quot;NO&quot; (the player is NOT a &quot;black&quot; player). Then the moderator announces, &quot;The Sheriff asleep,&quot; and the Sheriff puts the mask back on.</p>

<p>This same ritual continues during subsequent &quot;nights,&quot; even when the Don or Sheriff are voted off or eliminated from the table, in order to avoid providing additional clues as to the remaining players.</p>

<p>The moderator announces, &quot;Morning. All wake up.&quot; All players take off their masks. The moderator reveals the results of the &quot;shooting.&quot; Either the &quot;Mafia missed&quot; or the &quot;Mafia eliminated player number __.&quot; The eliminated player has the right to say last words (no more than 1 minute) and must then leave the table.</p>

<p>A new discussion begins. Player 2 starts discussion during the second day. If player 2 was voted off during the first day or eliminated during the first night, then player 3 starts discussion. This is done in order to avoid giving an advantage to the same player (in this case, it would be player 10) to conclude discussions two &quot;days&quot; in a row.</p>

<p>The game continues in the order of &quot;day&quot; and &quot;night&quot; until all the &quot;black&quot; players are voted off and the &quot;reds&quot; win, or until there is the same number of &quot;red&quot; and &quot;black&quot; players left at the table and the &quot;blacks&quot; win.</p>

<p>&nbsp;</p>

<h2>SOME PECULIARITIES OF THE GAME</h2>

<p>The Sheriff has information about true identity of &quot;checked&quot; players. If the Sheriff finds a black player, then an effort must be made during the &quot;day&quot; to vote-off that particular player. Yet, the Sheriff should try to keep his/her identity closed, for otherwise the &quot;blacks&quot; would try to vote him/her off or eliminate at &quot;night&quot; in order to exclude the possibility of further checks. Sheriff&#39;s elimination makes the game more difficult for the &quot;reds&quot; since their team loses the only source of true information. Yet, if the game becomes too complicated or situation becomes critical, the Sheriff should open up and identify &quot;checked&quot; players in order to rescue the team from a defeat.</p>

<p>A &quot;black&quot; player can also bluff - open up and pretend to be Sheriff in order to mislead the &quot;red&quot; team. In this case, the true Sheriff, as a rule, should also open up in order to clarify the game for the &quot;red&quot; players and avoid their complete confusion.</p>

<p>The &quot;black&quot; team can also eliminate one of their own during the night. This bluff allows one of the black players to open up as a Sheriff during the last statement and confuse the &quot;red&quot; players by falsely framing &quot;checked&quot; players.</p>

<p>&nbsp;</p>

<h2>CODE OF LAWS</h2>

<p>1. Players have no right to exchange seats with other players.</p>

<p>2. During the game, players have no right to pronounce the words &quot;I swear.&quot; Players have no right to swear in any other way or appeal to any religion. For this violation, a player will be dismissed from the game without warning.</p>

<p>3. Players are allowed to speak only at their turn. For speaking without permission from the moderator, players receive a warning.</p>

<p>4. During discussions, players are allowed either 1 minute or 30 seconds for their speeches and must stop when the moderator says &quot;Thank You.&quot; If the player continues to speak in excess of the allocated time, a warning is given.</p>

<p>5. Players have no right to sing, whistle, dance, bang on the table, talk or create other distractions to disrupt the course of the &quot;night.&quot; For this violation, the player receives a warning from the moderator.</p>

<p>6. The moderator has the right to give warning to a player for:</p>

<p>a. unethical conduct;</p>

<p>b. excessive gesticulation, hindering the course of the game and diverting players&#39; attention from the game;</p>

<p>c. other violations determined by the moderator.</p>

<p>7. After 3 warnings, the player loses the right to speak during one round of discussion (the player is still allowed to nominate a candidate to be voted-off, however).</p>

<p>8. After 4 warnings the player is dismissed from the game.</p>

<p>9. The dismissed player should immediately leave the table and has no right to a last statement.</p>

<p>10. Players have no right to curse or insult other players. For this violation, they are dismissed from the game.</p>

<p>11. Players may not cheat or deliberately peak from under their mask during the &quot;night.&quot; If this violation is detected, they are suspended from the game and deprived of their Club membership. If this violation occurs involuntarily, they are only dismissed from the game.</p>

<p>12. While voting, players should keep their hands on the game table till the end of voting, when the moderator announces &quot;Thank You.&quot; For violation of this rule, a player is dismissed from the game. The player is dismissed from the game for voting for more than one player during the &quot;day.&quot; If a&nbsp;player doesn&#39;t physically vote, then that player&rsquo;s vote is automatically counted for&nbsp;the last candidate.</p>

<p>13. A warning is given to a player showing the number of a candidate to be voted off after Voting is announced by the Moderator.</p>

<p>14. As soon as the moderator announces &quot;Night,&quot; players should immediately put on their masks. In case of a delay, a player receives a warning.</p>

<p>15. A player is dismissed from the game for shouting &quot;who to shoot at night&quot; after the announcement of &quot;Night.&quot; If the player only shows the number of to be shut player, then that player receives the warning.</p>

<p>16. A player is dismissed from the game for showing/hinting the number of to be checked player during the sheriff&#39;s round of cheching.</p>

<p>17. Players, individually or as a team, have the right to protest the outcome of a game if they believe that the rules were violated. In this case, moderator, along with the assistants and the president of the club may review the video recording of the game and make a decision for or against annulment of the game. In the case of annulment, the game is played again.</p>

<p>18. If a player protests before the end of the game, that player is dismissed from the game.</p>
',
            'extras'     => '{"title_rus":"\u0418\u0433\u0440\u0430"}',
            'deleted_at' => NULL,
        ]);

        DB::table('pages')->insert([
            'template'   => 'simple_page',
            'name'       => 'History',
            'title'      => 'History',
            'slug'       => 'history',
            'content'    => '<p>The psychological game of Mafia is played in Maf clubs all around the world. It is also known in mainstream culture as &ldquo;Assassin,&rdquo; &ldquo;Werewolf&rdquo; and &ldquo;Witch Hunt.&rdquo; This entertaining role playing game is rapidly gaining popularity among the young and mature men and women of all nationalities. The game&rsquo;s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia. The rules were later solidified by a group of young students from Yerevan State Medical Institute in 1980s who branded the game &ldquo;Maf.&rdquo;&nbsp; After this, Maf spread globally to include clubs first in Russia, followed by Armenia, Ukraine and the United States of America. MAF CLUB corporation based in California, USA, currently holds all copyrights and trademarks associated with the game of MAFIA, and operates&nbsp;clubs in the USA, Russia, Armenia and Ukraine.</p>

<p><img alt="" src="http://mafportal.com/uploads/yauza.jpeg" style="float:left; height:304px; width:407px" />Although majority of players are bright intellectuals, the game has rather psychological character. Interestingly enough, a professor with multiple degrees who spends most of his time in a laboratory may play worse than a salesman with a high school diploma who works with people and understands their psychology. Imagine a dimly lit room with a grand meeting table. Around it, ten players are seated. They do not know who plays in their own team, nor do they know who plays against them. But in order to survive, they must all figure it out before it is too late, before the other players take them out of the game.</p>

<p>&nbsp;</p>

<p><img alt="" src="http://mafportal.com/uploads/_MG_7550.jpg" style="float:right; height:262px; width:395px" />MAF Club corporation operates its clubs with a standard of high class environment and entertainment. However, the game already moved beyond clubs! Several successful television shows were already produced in Russian and Armenian. The script for a movie about &quot;Citizens&quot; already presented to producers. MAF CLUB corporation holds many regional as well as international tournaments. The most notable of all tournaments is The Annual Maf World Cup in Las Vegas with a minimal guaranteed cash prize of $30,000. The 3rd Annual MAF World Cup will take place from August 21 to 24, 2014.</p>

<p>&nbsp;</p>
',
            'extras'     => '{"title_rus":"\u0418\u0441\u0442\u043e\u0440\u0438\u044f"}',
            'deleted_at' => NULL,
        ]);

        DB::table('pages')->insert([
            'template'   => 'simple_page',
            'name'       => 'Home',
            'title'      => 'Maf club',
            'slug'       => 'maf-club',
            'content'    => '<p>The psychological game of Mafia is played in Maf clubs all around the world. It is also known in mainstream culture as &ldquo;Assassin,&rdquo; &ldquo;Werewolf&rdquo; and &ldquo;Witch Hunt.&rdquo; This entertaining role playing game is rapidly gaining popularity among the young and mature men and women of all nationalities. MAF CLUB corporation based in California, USA, currently holds all copyrights and trademarks associated with the game of MAFIA, and operates clubs in the USA, Russia, Armenia and Ukraine. MAF Club corporation operates its clubs with a standard of high class environment and entertainment</p>',
            'extras'     => '',
            'deleted_at' => NULL,
        ]);

        DB::table('pages')->insert([
            'template'   => 'contacts_page',
            'name'       => 'Contact',
            'title'      => 'Contact',
            'slug'       => 'contact',
            'content'    => '<p>MAF Club International operates in many countries and conducts four major tournaments in Moscow, Russia, Kiev, Ukraine, Yerevan, Armenia, and Las Vegas, USA. For the information about joining the MAF Club International or for any questions about the MAF World Cup in Las Vegas, please contact the US office: MAF Club, Inc.</p>',
            'extras'     => '{"title_rus":"\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u044b","content_rus":"<p>MAF Club International \u0440\u0430\u0431\u043e\u0442\u0430\u0435\u0442 \u0432\u043e \u043c\u043d\u043e\u0433\u0438\u0445 \u0441\u0442\u0440\u0430\u043d\u0430\u0445 \u0438 \u043f\u0440\u043e\u0432\u043e\u0434\u0438\u0442 \u0447\u0435\u0442\u044b\u0440\u0435 \u043a\u0440\u0443\u043f\u043d\u044b\u0445 \u0442\u0443\u0440\u043d\u0438\u0440\u0430 \u0432 \u041c\u043e\u0441\u043a\u0432\u0435, \u0420\u043e\u0441\u0441\u0438\u044f, \u041a\u0438\u0435\u0432\u0435, \u0423\u043a\u0440\u0430\u0438\u043d\u0430, \u0415\u0440\u0435\u0432\u0430\u043d\u0435, \u0410\u0440\u043c\u0435\u043d\u0438\u044f, \u0438 \u041b\u0430\u0441-\u0412\u0435\u0433\u0430\u0441\u0435, \u0421\u0428\u0410. \u0417\u0430 \u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u0435\u0439 \u043e \u0432\u0441\u0442\u0443\u043f\u043b\u0435\u043d\u0438\u0438 \u0432 MAF Club International \u0438\u043b\u0438 \u043f\u043e \u043b\u044e\u0431\u044b\u043c \u0434\u0440\u0443\u0433\u0438\u043c \u0432\u043e\u043f\u0440\u043e\u0441\u0430\u043c \u043e MAF World Cup \u0432 \u041b\u0430\u0441-\u0412\u0435\u0433\u0430\u0441\u0435, \u043f\u043e\u0436\u0430\u043b\u0443\u0439\u0441\u0442\u0430, \u043e\u0431\u0440\u0430\u0449\u0430\u0439\u0442\u0435\u0441\u044c \u0432 \u043e\u0444\u0438\u0441 \u0421\u0428\u0410: MAF Club, Inc.<\/p>\r\n","phones":"[{\"country\":\"USA\",\"phone\":\"+1 (818) 388-3113\",\"country_ru\":\"\u0421\u0428\u0410\"},{\"country\":\"Russia\",\"phone\":\"+7 (910) 000-1970\",\"country_ru\":\"\u0420\u043e\u0441\u0441\u0438\u044f\"},{\"country\":\"Ukraine\",\"phone\":\"+38 (096) 528-8410\",\"country_ru\":\"\u0423\u043a\u0440\u0430\u0438\u043d\u0430\"},{\"country\":\"Armenia\",\"phone\":\"+374 (91) 42-5722\",\"country_ru\":\"\u0410\u0440\u043c\u0435\u043d\u0438\u044f\"}]","email":"info@mafportal.com","facebook":"https:\/\/www.facebook.com\/","instagram":"https:\/\/www.instagram.com\/","twitter":"https:\/\/twitter.com\/"}',
            'deleted_at' => NULL,
        ]);

        DB::table('pages')->insert([
            'template'   => 'footer',
            'name'       => 'Footer',
            'title'      => 'Footer',
            'slug'       => 'footer',
            'content'    => NULL,
            'extras'     => '{"phones":"[{\"country\":\"USA\",\"phone\":\"+1 (818) 388-3113\",\"country_ru\":\"\u0421\u0428\u0410\"},{\"country\":\"Russia\",\"phone\":\"+7 (910) 000-1970\",\"country_ru\":\"\u0420\u043e\u0441\u0441\u0438\u044f\"},{\"country\":\"Ukraine\",\"phone\":\"+38 (096) 528-8410\",\"country_ru\":\"\u0423\u043a\u0440\u0430\u0438\u043d\u0430\"},{\"country\":\"Armenia\",\"phone\":\"+374 (91) 42-5722\",\"country_ru\":\"\u0410\u0440\u043c\u0435\u043d\u0438\u044f\"}]","email":"info@mafportal.com","facebook":"https:\/\/www.facebook.com\/","instagram":"https:\/\/www.instagram.com\/","twitter":"https:\/\/twitter.com\/"}',
            'deleted_at' => NULL,
        ]);
    }
}
