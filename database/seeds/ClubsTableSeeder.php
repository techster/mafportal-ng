<?php

use Illuminate\Database\Seeder;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clubs')->insert([
            'title'       => 'Los Angeles',
            'slug'        => 'los-angeles',
            'city'        => 'Los Angeles',
            'country_id'  => '1',
            'image'       => '/uploads/_MG_7550.jpg',
            'table_ratings_id' => '1',
            'text' => "<p>Congratulations to&nbsp;<strong>Naira Oganesyan&nbsp;</strong>and&nbsp;<strong>Milena Melkonyan</strong>, the&nbsp;best players of the 2013-2014 season. For the first time in the history of&nbsp;any Maf Club, two players - and both<strong>women&nbsp;</strong>- earned the best and identical ranking and will share the title of DON! However, because of shared title, both Dons will be allowed to be nominated during the first day and shot during the first night. Both Dons will still keep the right to take an additional minute for their speech during each game. For the certificates of other Best players, please visit&nbsp;our&nbsp;<strong><a href=\"http://www.mafportal.com/index.php/lafame\">Hall of Fame</a></strong>.&nbsp;</p>
<p>The 2014-2015 season starts on October 3 with the same schedule of regular games on Tuesdays, Fridays and Saturdays. It will have two half seasons, lasting 4 months each: October-January and March-June.</p>
<p><strong>LOS ANGELES MAF CLUB HISTORY</strong></p>
<p>The very first professional Maf Club was opened in Los Angeles in April of 2000 and started with 20 members. More than 2000 players participated in Maf games since the first season. The Maf Club is currently operates in its new location at 113 N. Maryland avenue in Glendale, California. The Maf Club is open to its members every Tuesday, Friday and Saturday from 8 pm till 3.30 am. The games are played simultaneously in 2 professional red and black rooms.</p>
<p><strong>LOS ANGELES MAF CLUB MEMBERSHIP</strong></p>
<p>The&nbsp;<strong>Maf Club membership&nbsp;</strong>is simplified in 2014:&nbsp;<strong>$150 per month</strong>. The club membership allows unlimited and free games on a first come first serve basis. Considering at least 12 playing games per month, it comes to&nbsp;<strong>$12.50 per playing day</strong>. Every Maf Club member, who stays active for the full season (8 months: October-January and March-June), will receive complimentary entry into the 4th Annual Maf World Cup in Las Vegas. Members who stay active only part of the season, will accumulate $50 per paid month toward the entry fee for the 4th Annual Maf World Cup in Las Vegas. Non-members of the club are also allowed&nbsp;to play rated games on a first come first serve basis paying&nbsp;<strong>$10 per game</strong>. Every player receives individual rating even if he or she is not an official member of the Maf Club.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Houston',
            'slug'        => 'houston',
            'city'        => 'Houston',
            'country_id'  => '1',
            'image'       => '/uploads/_MG_7550.jpg',
            'text' => "<p><strong>Club News </strong></p>
<p>The game&rsquo;s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia. The rules were later solidified by a group of young students from Yerevan State Medical Institute in 1980s Armenia who branded the game &ldquo;Maf.&rdquo; After this, Maf spread globally to include clubs first in Russia, followed by Armenia, Ukraine and the United States of America; the club in Yerevan has been in operation for over 20 years. Annual tournaments in Moscow and Yerevan is now being followed by a tournament in Las Vegas for the first time in the summer of 2012 hosted by the original creators of Maf.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'New York',
            'slug'        => 'new-york',
            'city'        => 'New York',
            'country_id'  => '1',
            'image'       => '/uploads/_MG_7550.jpg',
            'text' => "<p><strong>Club News </strong></p>
<p>The game&rsquo;s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia. The rules were later solidified by a group of young students from Yerevan State Medical Institute in 1980s Armenia who branded the game &ldquo;Maf.&rdquo; After this, Maf spread globally to include clubs first in Russia, followed by Armenia, Ukraine and the United States of America; the club in Yerevan has been in operation for over 20 years. Annual tournaments in Moscow and Yerevan is now being followed by a tournament in Las Vegas for the first time in the summer of 2012 hosted by the original creators of Maf.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Las Vegas',
            'slug'        => 'las-vegas',
            'city'        => 'Las Vegas',
            'country_id'  => '1',
            'image'       => '/uploads/_MG_7550.jpg',
            'text' => "<p><strong>Club News </strong></p>
<p>The game&rsquo;s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia. The rules were later solidified by a group of young students from Yerevan State Medical Institute in 1980s Armenia who branded the game &ldquo;Maf.&rdquo; After this, Maf spread globally to include clubs first in Russia, followed by Armenia, Ukraine and the United States of America; the club in Yerevan has been in operation for over 20 years. Annual tournaments in Moscow and Yerevan is now being followed by a tournament in Las Vegas for the first time in the summer of 2012 hosted by the original creators of Maf.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Коктейль-Династия',
            'slug'        => 'kokteil-dinahstiia',
            'city'        => 'Moscow',
            'country_id'  => '2',
            'image'       => '/build/img/about2.jpg',
            'text' => "<p><strong>Club News </strong></p>
<p>The game&rsquo;s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia. The rules were later solidified by a group of young students from Yerevan State Medical Institute in 1980s Armenia who branded the game &ldquo;Maf.&rdquo; After this, Maf spread globally to include clubs first in Russia, followed by Armenia, Ukraine and the United States of America; the club in Yerevan has been in operation for over 20 years. Annual tournaments in Moscow and Yerevan is now being followed by a tournament in Las Vegas for the first time in the summer of 2012 hosted by the original creators of Maf.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Yerevan',
            'slug'        => 'yerevan',
            'city'        => 'Yerevan',
            'country_id'  => '3',
            'image'       => '/uploads/_MG_7550.jpg',
            'text' => "<p><strong>Ара Гезалян &ndash; Первый Магистр игры &laquo;МАФИЯ&raquo;!</strong></p>
<p><strong>ДАМЫ И ГОСПОДА!</strong></p>
<p>Завершился одиннадцатый чемпионат мира по игре &laquo;МАФИЯ&raquo;! 20 участников, приехавших на чемпионат из Москвы, Еревана и Лос Анджелеса, боролись за степень Магистра. Примечательно, что пятеро из них, были представительницы прекрасного пола.</p>
<p>Золотым призером чемпионата и первым Магистром игры стал Ара Гезалян. Титул Магистра игры равносилен титулу Дона, он не зависит от социального статуса, политических взглядов и не передается по наследству, хотя в некоторых случаях заложен в генетическом коде. Серебряным призером чемпионата стал Гор Мусинян, а бронзу завоевала Карине Казарян.</p>
<p><strong>Поздравляем всех победителей!</strong></p>
<p><strong>Сергей Джагинян &ndash; Победитель турнира Десяти</strong></p>
<p>С 3 по 5 мая 2013 года в ереванском Маф Клубе прошло самое значимое за последние десять лет событие: Турнир Десяти Донов. В нем приняли участие все доны последних десяти лет. В результате горячих мафиозных игр победителем турнира стал Сергей Джагинян.</p>
<p><strong>Статистика 2012 года</strong></p>
<p><strong>За 2012 год&hellip;</strong></p>
<p>&hellip;было сыграно 253 игр</p>
<p>&hellip;черные выиграли 135 раз</p>
<p>&hellip;красные выиграли 118 раз</p>
<p>&hellip;больше всех сыграл (209 игр) и больше всех выиграл (97 побед) Гор Мусинян</p>
<p>&hellip;меньше всех сыграли Грант Тохатян и Ерванд Тарвердян &ndash; по одному разу</p>
<p>&hellip;больше всех сыграл красным (150) и больше всех выиграл красным (69) Гор Мусинян</p>
<p>&hellip;больше всех сыграл черным (71) и больше всех выиграл черным (36) Арам Гаспарян</p>
<p>&hellip;больше всех сыграл Доном (24) и больше всех выиграл Доном (14) Армен Блеян</p>
<p>&hellip;больше всех сыграл Шерифом (19) и больше всех выиграл Шерифом (10) Арам Гаспарян</p>
<p><strong>Номинанты 2012 года</strong></p>
<p>Чемпионы по маф-блоту - Рубен Джагинян, Гагик Григорян</p>
<p>Чемпион по маф-преферансу - Гагик Григорян</p>
<p>За преданность Клубу- Карине Казарян</p>
<p>Открытие года - Давид Векилян</p>
<p>Лучший красный - Оганес Погосян</p>
<p>Лучший черный - Акоп Григорян</p>
<p>Лучший Дон - Ара Гезалян</p>
<p>Лучший Шериф - Георгий Погосян</p>
<p>Лучший ход - Давид Бабаханян</p>
<p>Честная Игра - Армен Тавадян</p>
<p>Лучший игрок года - Давид Бабаханян</p>
<p><em><strong>История </strong></em></p>
<p>Система &laquo;Маф-клуб&raquo; - это система, &laquo;технологично&raquo; организованная согласно принципу &laquo;Закрытый Клуб&raquo;, членство в которой дает уникальную в своем роде возможнось для комфортного общения и интересного, &laquo;живого&raquo; времяпровождения за игрой в Мафию и другими клубными играми.</p>
<p>Система основана в 1996 году - с открытия первого маф-клуба в Ереване, который в 1998 году был зарегистрирован официально и объявлен закрытым клубом. Таким образом, на сегодняшний день Система &laquo;Маф-клуб&raquo; насчитывает уже почти 17-летнюю историю, богатую клубными событиями, сложившимися традициями, выработанными за эти годы правилами, обязательными для всех членов клуба и призванными сделать клубную атмосферу легкой и приятной для всех. Система имеет свой гимн и свой логотип, в ней разработана игровая и клубная атрибутика, сформулирован и утвержден Свод правил и Нюансов Игры, создана система подсчета Рейтинга игроков.</p>
<p>Правом посещения Kлубов Системы обладают лишь владельцы членских Карт и их гости.</p>
<p><strong>Информация к сведению</strong>: <em>со дня основания членством в Системе &laquo;Маф-клуб&raquo; обладали более 300 человек.&nbsp;В настоящее время членами клубов Системы являются около 100 человек.</em></p>
<p><strong>Клубные карты</strong></p>
<p>В Системе действуют Гостевые, Клубные, Серебряные и Золотые карты. Карты именные, без права передачи другому лицу и действительны во всех клубах Системы &laquo;Маф-Клуб&raquo;, но при этом каждый член Клуба обязан иметь свою порт-прописку (т.е Клуб).</p>
<p><strong>Гостевая Карта</strong></p>
<p>Гостевая Карта Системы &laquo;Маф-клуб&raquo; дает право на:</p>
<p>* посещение данного Клуба в течение некоторого ознакомительного периода (минимум 2 месяца) - до официального вступления в Систему.</p>
<p>* приобретение Клубной Карты после процедуры вступления в Систему</p>
<p>* участие в одной Игре (по согласованию с Ведущим) в течение одного клубного дня в порядке очереди или право на:</p>
<p>* единовременное платное посещение Клуба в сопровождении члена Системы &laquo;Маф-клуб&raquo; или при согласовании с руководством Клуба.</p>
<p><strong>Клубная Карта</strong></p>
<p>Карта, обязательная для всех членов Системы &laquo;Маф-клуб&raquo;, не являющихся владельцами золотых и серебряных Карт.</p>
<p>Клубная Карта члена Системы &laquo;Маф-клуб&raquo; дает право на:</p>
<p>* участие в одной Игре (по согласованию с Ведущим) в течение одного клубного дня в порядке очереди</p>
<p>* участие в карточных клубных турнирах</p>
<p>* включение в систему подсчета рейтинга</p>
<p>* дополнительные права, определямые руководством данного Клуба, с условием, что они не противоречат основным правилам и законам Системы &laquo;Маф-Клуб&raquo;.</p>
<p>Клубная Карта не может быть &laquo;заморожена&raquo; - она оплачивается на протяжении всего членства, вне зависимости от того, насколько часто Вы посещаете клуб или по каким -либо причинами длительное время отсутствуете.</p>
<p><strong>Серебряная Карта</strong></p>
<p>Серебряная Карта члена Системы &laquo;Маф-клуб&raquo; дает право на:</p>
<p>* участие в любых Играх в порядке очереди</p>
<p>* 20% скидку в баре Клуба</p>
<p>* участие в карточных клубных турнирах</p>
<p>* приглашение в Клуб двоих гостей, каждый из которых может 1 раз за вечер сесть за игровой стол. В случае длительного отсутствия (от 1-го до 3-х месяцев), оплатив 20% от суммы членского взноса, владелец Серебряной Карты может &laquo;заморозить&raquo; ее на это время. В случае, если срок отсутствия превысил 3 месяца, то по возвращении владелец карты должен пройти согласованную с руководством Клуба процедуру возобновления членства.</p>
<p>Правом на приобретение Серебряной Карты обладают лишь владельцы Клубных Карт.</p>
<p><strong>Золотая карта </strong></p>
<p>Золотая Карта члена Системы &laquo;Маф-клуб&raquo; дает право на:</p>
<p>* внеочередное участие во всех Играх</p>
<p>* 30% скидку в баре Клуба</p>
<p>* участие в карточных клубных турнирах</p>
<p>* приглашение в Клуб трех гостей, каждый из которых может 1 раз за вечер сесть за игровой стол. В случае длительного отсутствия (от 1-го до 6-и месяцев), оплатив 20% от суммы членского взноса, владелец Золотой Карты может &laquo;заморозить&raquo; ее на это время. В случае, если срок отсутствия превысил 6 месяцев, то по возвращении владелец карты должен пройти согласованную с руководством Клуба процедуру возобновления членства.</p>
<p>Правом на приобретение Золотой Карты обладают лишь владельцы Клубных и Серебряных Карт.</p>
<p>При посещении клубов Системы &laquo;Маф-Клуб&raquo; владелец Карты обязан иметь ее при себе.</p>
<p><strong>Клубные законы и правила</strong></p>
<p>Все административные и организационные вопросы, в том числе, связанные с членством в Системе, регулируются ее руководством согласно принятому уставу Системы &laquo;Маф клуб&raquo;.</p>
<p>Верховным законодательным органом Системы &laquo;Маф-Клуб&raquo; является Совет Клуба, который возглавляет Президент Системы &laquo;Маф-Клуб&raquo;.</p>
<p>В каждом клубе Системы действует Консультативный Совет, избирающийся членами данного клуба сроком на один год.</p>
<p><strong>Вступление в Систему</strong></p>
<p>Для вступления в Систему &laquo;Маф-Клуб&raquo; необходимо иметь рекомендации одного члена Совета Клуба и двух членов Консультативного Совета Клуба. Член Клуба, предлагающий новую кандидатуру, должен заручиться рекомендациями вышеуказанных персон. Предлагать кандидатуру для вступления в ряды Клуба имеют право только члены Клуба. Член Клуба, предлагающий нового кандидата, должен гарантировать полное знание им правил и законов игры, а также традиций Клуба. Президент Клуба имеет право наложить вето на кандидатуру, представленную для вступления в Клуб.</p>
<p>Члены Системы &laquo;Маф-Клуб&raquo; обязаны следовать правилам, принятым в Системе. В частности:</p>
<p>* четко соблюдать правила и законы игры в мафию</p>
<p>* следовать устоям и традициям Клуба</p>
<p>* соблюдать принятый в Системе этикет - в частности в Клубах строго запрещено появляться в спортивной одежде, пляжной обуви, в нетрезвом виде, в неряшливом образе и пр.</p>
<p>* вовремя вносить членские взносы</p>
<p>* не допускать задолженностей - членский взнос вносится ежемесячно, в начале текущего клубного месяца.</p>
<p>* соблюдать конфиденциальность</p>
<p>При нарушениях правил, а также при длительном непосещении Клуба (если только членская карта не &laquo;заморожена&raquo;), Совет Клуба оставляет за собой право принять решение о лишении &laquo;нарушителя&raquo; клубного членства.</p>
<p>Клубная карта является собственностью клуба и подлежит возврату, если ее владельцем принято решение прервать членство в Системе. При потере клубной карты владелец должен выплатить штраф в размере месячного членского взноса, соответствующего номиналу клубной карты.</p>
<p><strong>Турниры Системы</strong></p>
<p><strong>Чемпионат</strong></p>
<p>В 2003 году в Системе &laquo;Маф-клуб&raquo; был организован первый международный Чемпионат по игре Мафия, победитель которого стал обладателем бриллиантового перстня и титула Дона- Главы Семьи. В 2012 году состоялся 10-ый юбилейный Чемпионат и, соответственно, на сегодняшний день в анналы истории Системы вписаны имена первых десяти Донов:</p>
<p>Георгий Погосян (Дон 2003г., г. Ереван, клуб &laquo;Ереван&raquo;), Дмитрий Андреев (Дон 2004 г., г. Москва, клуб &laquo;Яуза&raquo;), Оганес Погосян (Дон 2005г., г. Ереван, клуб &laquo;Ереван&raquo;), Лилия Ли-Ми-Ян (Донья 2006г., г. Москва, клуб &laquo;Москва&raquo;), Армен Ванян (Дон 2007 г., г. Москва, клуб &laquo;Яуза&raquo;), Андраник Карапетян (Дон 2008 г., г. Москва, клуб &laquo;Москва&raquo;), Армен Блеян (Дон 2009 г., г. Ереван, клуб &laquo;Ереван&raquo;), Раффи Захарян (Дон 2010 г., г. Ереван, клуб &laquo;Ереван&raquo;), Рубен Есаян (Дон 2011 г., г. Москва, клуб &laquo;Москва&raquo;) и Сергей Джагинян (Дон 2012г., г.Москва, клуб &laquo;Москва&raquo;).</p>
<p>В мае 2013 года в Ереване пройдет XI Чемпионат по игре Мафия, в ходе которого также состоится долгожданный &laquo;Турнир Десяти&raquo;: Десять Донов Системы &laquo;Маф- клуб&raquo;, определившиеся в ходе ежегодных &laquo;мафиозных игр&raquo; за последние десять лет, наконец встретятся за игровым столом!</p>
<p><strong>Открытый Кубок Москвы</strong></p>
<p>Кубок разыгрывается с 2008 года. В 2012 году был проведен V-ый Кубок Москвы, обладателем которого стал Георгий Агабабаев.</p>
<p><strong>Кубок города Ереван по игре &laquo;Мафия&raquo;</strong></p>
<p>Кубок Еревана разыгрывался 2 раза: в 2010 и 2012 гг. Обладателями кубка стали Гор Мусинян и Акоп Койлоян.</p>
<p><strong>Ежегодный турнир по игре &laquo;Мафия&raquo; в Лас-Вегасе</strong></p>
<p>Первый турнир был проведен в 2012 году. Победила красная команда.</p>
<p>В августе 2013 года в игровой и развлекательной столице мира состоится Второй ежегодный турнир &laquo;Кубок Лас Вегаса&raquo;!</p>
<p><strong>TV</strong></p>
<p>На ведущих телеканалах Армении - Армения TB и ТВ 12-в течение 3-х телевизионных сезонов, неизменно набирая высшие рейтинги, выходил в эфир телепроект &laquo;Красное или черное&raquo;. Всего было снято около 100 телепередач, в которых принимали участие как члены клубов Системы, так и победители организованных заранее отборочных турниров.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Khmelnitski',
            'slug'        => 'khmelnitski',
            'city'        => 'Khmelnitski',
            'country_id'  => '4',
            'image'       => '/uploads/_MG_7550.jpg',
            'text' => "<p><strong>Новости Клуба </strong></p>
<p>Поздравляем победителя первого в своем роде турнира &quot;Лиги Выдающихся Игроков 2013&quot; господина Линкольна (Семена Терещенко), уроженца Big Ben Mafia Club (город Киев)!</p>
<p>Орг комитет выражает свою благодарность всем, кто принимал активное участие в реализации проекта &quot;Лиги Выдающихся Игроков 2013&quot;, всем участникам, которые подарили непередаваемые эмоции (как положительные, так и мегаположительные), к частности г-ну Профессору, г-ну Di Fortuna, г-ну Советнику, г-же Багире, г-ну Удаву, г-ну MaSsimus, г-ну Персику, г-ну Дориану, г-же Deja Vu, г-ну Ross, г-же Конфетке и многим другим.</p>
<p>Ну что ж, да здравствует &quot;Лига Выдающихся Игроков 2014&quot;! Напоминаем, что оргкомитет оставляет за собой исключительное право приглашать участников в &quot;Высшую Лигу&quot; Мафии!</p>
<p>Мы обязательно учтем ошибки, которые были допущены на всех этапах данного турнира!</p>
<p>Мы также с радостью уведомляеи о предстоящих турнирах: экслюзивный Чемпионат клубов системы в Ереане в Мае, Открытый Кубок Украины в Киеве с 27 по 29 июня и Третий Ежегодный Кубок Мира в Лас Вегасе с минимальным гарантированным призом в $30,000.</p>
<p>До новых встреч, до новый побед!</p>
<p>Maf Club Хмельницкий работает по графику:</p>
<p>Каждую среду с 20:00</p>
<p>Каждую пятницу с 20:00</p>
<p>Каждое воскресенье с 20:00</p>
<p>Для дополнительной информации о клубе пожалуйста пишите на электронную почту президента клуба Роберта Арутюняна: mafiarob@icloud.com.</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Kiev Big Ben',
            'slug'        => 'kiev-big-ben',
            'city'        => 'Kiev',
            'country_id'  => '4',
            'image'       => '/uploads/_MG_7550.jpg',
            'text' => "<p><strong>Новости Клуба </strong></p>
<p>Клуб Big Ben вместе с корпорацией Maf Club объявляет открытой регистрацию на 1-ый Кубок Европы по Мафии, который пройдет с 27 по 29 июня 2014 года.</p>
<p>В нашем клубе игры проходят 6 раз в неделю: с понедельника по субботу. Начало в 19:00.</p>
<p>Место нахождения клуба:</p>
<p>г. Киев, Оболонский проспект 1-Б</p>
<p>ТРЦ &quot;Dream Town&quot; атриум Франция</p>
<p>3-й этаж, паб Big Ben</p>"
        ]);

        DB::table('clubs')->insert([
            'title'       => 'The Black Cat',
            'slug'        => 'the-black-cat',
            'city'        => 'San Francisco',
            'country_id'  => '1',
            'image'       => 'uploads/clubs/USA/black-cat/image1.jpeg',
            'text'        => NULL
        ]);

        DB::table('clubs')->insert([
            'title'       => 'Moscow',
            'slug'        => 'moscow',
            'city'        => 'Moscow',
            'country_id'  => '2',
            'image'       => '/build/img/about2.jpg',
            'text' => "<p><strong>Club News </strong></p>
<p>The game&rsquo;s origins can be traced to the Masons over 150 years ago. It later found its way into the training methods of KGB security agents in Soviet Russia. The rules were later solidified by a group of young students from Yerevan State Medical Institute in 1980s Armenia who branded the game &ldquo;Maf.&rdquo; After this, Maf spread globally to include clubs first in Russia, followed by Armenia, Ukraine and the United States of America; the club in Yerevan has been in operation for over 20 years. Annual tournaments in Moscow and Yerevan is now being followed by a tournament in Las Vegas for the first time in the summer of 2012 hosted by the original creators of Maf.</p>"
        ]);
    }
}
