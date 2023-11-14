-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2023 at 11:10 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bocchimp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Other'),
(2, 'Rock'),
(3, 'Pop'),
(4, 'Jazz'),
(5, 'Classical'),
(6, 'Hip Hop');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `comment_date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_text`, `comment_date`, `user_id`, `song_id`) VALUES
(1, 'good song', '2023-04-27', 1, 1),
(2, 'test', '2023-05-07', 1, 1),
(3, 'super idol de xiaorong', '2023-05-07', 2, 1),
(4, 'cool music kanye, very cool thnak you', '2023-05-07', 1, 7),
(5, 'wide puteen', '2023-05-07', 1, 6),
(6, 'lol', '2023-05-07', 1, 6),
(7, 'bocchi za rok\r\n', '2023-05-07', 1, 4),
(8, 'shinji get in the robot!', '2023-05-07', 1, 2),
(9, 'retvrn to hyperborreal', '2023-05-07', 1, 5),
(10, 'kita chan', '2023-05-07', 1, 8),
(11, 'i love kita chan ', '2023-05-07', 3, 8),
(12, 'very cool', '2023-05-07', 3, 6),
(13, 'lmao', '2023-05-07', 3, 1),
(14, 'nice', '2023-05-07', 3, 6),
(15, 'wwwww', '2023-05-07', 1, 9),
(16, 'nice song', '2023-05-07', 1, 3),
(17, 'nice sonice songng', '2023-05-07', 1, 3),
(18, 'nice sonice songng', '2023-05-07', 1, 3),
(19, 'nice sonice songng', '2023-05-07', 1, 3),
(20, 'nice sonice songng', '2023-05-07', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `lyrics`
--

DROP TABLE IF EXISTS `lyrics`;
CREATE TABLE `lyrics` (
  `lyrics_id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `lyrics_txt` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lyrics`
--

INSERT INTO `lyrics` (`lyrics_id`, `song_id`, `lyrics_txt`) VALUES
(1, 1, '[length:04:21.07]\r\n[re:www.megalobiz.com/lrc/maker]\r\n[ve:v1.2.3]\r\n[00:01.38]沈むように 溶けてゆくように\r\n[00:08.63]二人だけの空が広がる夜に\r\n[00:31.38]「さよなら」だけだった\r\n[00:33.63]その一言で全てが分かった\r\n[00:37.38]日が沈み出した空と君の姿\r\n[00:41.88]フェンス越しに重なっていた\r\n[00:46.13]初めて会った日から\r\n[00:48.38]僕の心の全てを奪った\r\n[00:52.13]どこか儚い空気を纏う君は\r\n[00:56.63]寂しい目をしてたんだ\r\n[01:00.13]いつだってチックタックと鳴る世界で何度だってさ\r\n[01:03.63]触れる心無い言葉うるさい声に涙が零れそうでも\r\n[01:08.13]ありきたりな喜び きっと二人なら見つけられる\r\n[01:14.88]騒がしい日々に 笑えない君に\r\n[01:18.63]思い付く限り眩しい明日を\r\n[01:22.38]明けない夜に落ちてゆく前に\r\n[01:26.13]僕の手を掴んでほら\r\n[01:29.13]忘れてしまいたくて 閉じ込めた日々も\r\n[01:33.63]抱きしめた温もりで溶かすから\r\n[01:37.13]怖くないよ いつか日が昇るまで 二人でいよう\r\n[01:58.13]君にしか見えない\r\n[02:00.63]何かを見つめる君が嫌いだ\r\n[02:04.13]見惚れているかのような 恋するような\r\n[02:08.63]そんな顔が嫌いだ\r\n[02:12.38]信じていたいけど信じれないこと\r\n[02:14.38]そんなのどうしたってきっと\r\n[02:16.13]これからだっていくつもあって\r\n[02:17.88]そのたんび怒って泣いていくの\r\n[02:19.63]それでもきっといつかはきっと僕らはきっと\r\n[02:22.38]分かり合えるさ 信じてるよ\r\n[02:40.63]もう嫌だって 疲れたんだって\r\n[02:43.88]がむしゃらに差し伸べた僕の手を振り払う君\r\n[02:47.88]もう嫌だって 疲れたよなんて\r\n[02:50.13]本当は僕も言いたいんだ\r\n[02:54.63]ほらまたチックタックと鳴る世界で何度だってさ\r\n[02:58.13]君の為に用意した言葉どれも届かない\r\n[03:01.38]「終わりにしたい」だなんてさ\r\n[03:05.88]釣られて言葉にした時 君は初めて笑った\r\n[03:11.13]騒がしい日々に笑えなくなっていた\r\n[03:14.88]僕の目に映る君は綺麗だ\r\n[03:18.88]明けない夜に溢れた涙も\r\n[03:22.38]君の笑顔に溶けていく\r\n[03:27.88]変わらない日々に泣いていた僕を\r\n[03:31.63]君は優しく終わりへと誘う\r\n[03:35.38]沈むように 溶けてゆくように\r\n[03:38.88]染み付いた霧が晴れる\r\n[03:42.13]忘れてしまいたくて 閉じ込めた日々に\r\n[03:46.38]差し伸べてくれた君の手を取る\r\n[03:50.13]涼しい風が空を泳ぐように今吹き抜けていく\r\n[03:56.88]繋いだ手を離さないでよ\r\n[04:00.38]二人今 夜に駆け出していく'),
(2, 2, ''),
(3, 3, '[ar:結束バンド]\n[ti:あのバンド]\n[length:03:33.03]\n[re:www.megalobiz.com/lrc/maker]\n[ve:v1.2.3]\n[00:02.39]作词 : 樋口愛\n[00:05.86]作曲 : 草野華余子\n[00:13.83]あのバンドの歌がわたしには\n[00:18.88]甲高く響く笑い声に聞こえる\n[00:23.93]あのバンドの歌がわたしには\n[00:29.52]つんざく踏切の音みたい\n[00:35.63]背中を押すなよ\n[00:40.68]もうそこに列車が来る\n[00:43.60]目を閉じる 暗闇に差す後光\n[00:46.52]耳塞ぐ 確かに刻む鼓動\n[00:53.96]胸の奥 身を揺らす心臓\n[00:59.27]ほかに何も聴きたくない\n[01:02.20]わたしが放つ音以外\n[01:09.36]不協和音に居場所を探したり\n[01:19.73]悲しい歌に救われていたんだけど\n[01:24.51]あのバンドの歌が誰かにはギプスで\n[01:30.35]わたし（だけが）間違いばかりみたい\n[01:34.06]目を閉じる 暗闇に差す後光\n[01:39.11]耳塞ぐ 確かに刻む鼓動\n[01:43.90]胸の奥 身を揺らす心臓\n[01:49.47]ほかに何も聴きたくない\n[01:52.13]わたしが放つ音以外\n[01:59.33]いらない\n[02:17.13]背中を押すなよ\n[02:22.17]容易く心触るな\n[02:26.69]出発のベルが鳴る\n[02:32.02]乗客は私一人だけ\n[02:35.27]手を叩く わたしだけの音\n[02:39.52]足鳴らす 足跡残すまで\n[02:44.83]目を開ける 孤独の称号\n[02:50.41]受け止める 孤高の衝動\n[02:54.66]今 胸の奥 確かめる心音\n[03:00.50]ほかに何も聴きたくない\n[03:03.95]わたしが放つ音以外'),
(4, 4, '[00:00.000] 作词 : ZAQ\n[00:01.000] 作曲 : 音羽-otoha-\n[00:15.144]突然降る夕立 　あぁ傘もないや嫌\n[00:21.030]空のご機嫌なんか知らない\n[00:25.031]季節の変わり目の服は　何着りゃいいんだろ\n[00:30.988]春と秋　どこいっちゃったんだよ\n[00:34.972]息も出来ない　情報の圧力\n[00:39.827]めまいの螺旋だ　わたしはどこにいる\n[00:44.656]こんなに　こんなに　息の音がするのに\n[00:50.787]変だね　世界の音がしない\n[00:56.123]足りない　足りない　誰にも気づかれない\n[01:00.360]殴り書きみたいな音　出せない状態で叫んだよ\n[01:05.343]「ありのまま」なんて　誰に見せるんだ\n[01:10.277]馬鹿なわたしは歌うだけ\n[01:15.161]ぶちまけちゃおうか　星に\n[01:29.559]エリクサーに張り替える作業もなんとなくなんだ\n[01:35.564]欠けた爪を少し触る\n[01:39.569]半径300mmの体で　必死に嗚いてる\n[01:45.566]音楽にとつちゃ　ココが地球だな\n[01:49.505]空気を握って　空を殴るよ\n[01:54.457]なんにも起きない　わたしは無力さ\n[01:59.347]だけどさ　その手で　この鉄を弾いたら\n[02:05.408]何かが変わって見えた…ような。\n[02:10.882]眩しい　眩しい　そんなに光るなよ\n[02:14.922]わたしのダサい影が　より色濃くなってしまうだろ\n[02:19.954]なんでこんな熱くなっちゃってんだ　止まんない\n[02:24.932]馬鹿なわたしは歌うだけ\n[02:29.875]うるさいんだって　心臓\n[02:42.684]蒼い惑星　ひとりぼっち\n[02:47.366]いっぱいの音を聞いてきた\n[02:52.752]回り続けて　幾億年\n[02:57.316]一瞬でもいいから…ああ\n[03:03.321]聞いて\n[03:04.454]聴けよ\n[03:05.211]わたし　わたし　わたしはここにいる\n[03:09.617]殴り書きみたいな音　出せない状態で叫んだよ\n[03:14.679]なんかになりたい　なりたい　何者かでいい\n[03:19.621]馬鹿なわたしは歌うだけ\n[03:24.735]ぶちまけちゃおうか　星に'),
(5, 5, ''),
(6, 6, ''),
(7, 7, '[ti:Believe What I Say]\n[ar:Kanye West]\n[lang:English]\n[length:04:02.44]\n[by:Jun]\n[re:www.rclyricsband.com]\n[ve:v0.0.5]\n[00:00.00]\n[00:00.40](Yo) yo (check our situation), yo\n[00:03.56]My men and my women\n[00:05.37](Yo) yo (check our situation), yo\n[00:08.32]My men and my wom-\n[00:09.98]You need something unexpected (yo, yo), some form of weapon\n[00:14.45]You ask him to feel protected (yo, yo), and still feel protected\n[00:19.21]Just one time for the record (yo, yo), just one time for the record\n[00:24.23]Don\'t agree with the message (yo, yo), don\'t agree with the methods\n[00:28.91]Don\'t let, don\'t let the lifestyle drag you down\n[00:33.87]Who knows when was the last time you felt the love\n[00:39.09]One last sparkle to follow in my light\n[00:43.89]One last sparkle to follow\n[00:48.60]Man, it\'s too early\n[00:50.22]What the hell you doing waking me up at 5:30?\n[00:52.43]Why the hell are you worried?\n[00:55.28]Play something that is very, very vibe-worthy\n[00:57.15]I don\'t want my mind alerting\n[00:59.94]People saying tweeting gonna make you die early\n[01:01.90]How \'bout have my heart hurting?\n[01:04.59]Hold it all inside, that could make you die early\n[01:06.90]Go on and get your best attorney\n[01:09.58]Something\'s there, feel it when I heard it\n[01:11.85]Just release the spirit, let it flow though\n[01:13.92]Have these n- leaving now with one leg like Flo-Jo\n[01:16.41]Nail me to the cross with long nails like Coco\n[01:18.92]Free Throat Coat for the throat goats\n[01:21.29]Even if I gotta do it solo, even if I gotta do it with no promo\n[01:26.27]I ain\'t got my point across\n[01:28.05]\'Til we finally get the cross and pass the point\n[01:30.34]So there\'s a couple things that I gotta quote\n[01:32.81]Don\'t involve yourself in things you don\'t have to know\n[01:35.35]I ain\'t never question what you was asking for\n[01:37.50]I gave you every single thing you was asking for\n[01:40.08]I don\'t understand how anybody could ask for more\n[01:42.16]Got a list of even more, I just laugh it off\n[01:44.98]I be going through things I had to wrote\n[01:47.10]Celebrity drama that only Brad\'d know\n[01:49.38]Too many family secrets, somebody pass the notes\n[01:52.42]Things I cried about I found laughable\n[01:54.95]Lil\' baby Jesus ain\'t laughing, no\n[01:57.30]Don\'t involve yourself in things that you ain\'t have to know\n[01:59.51]The big man upstairs ain\'t laughing, no\n[02:02.20]Don\'t involve yourself in things that you ain\'t have to know\n[02:04.15]Now here we are\n[02:06.33]You know I\'m not about it\n[02:09.08]Showed you my all\n[02:11.14]I let you into my thoughts\n[02:14.89]Don\'t let, don\'t let the lifestyle drag you down\n[02:19.42]Who knows when was the last time you felt the love\n[02:24.85]One last sparkle to follow in my light\n[02:29.39]One last sparkle to follow in love\n[02:34.46]One last sparkle to follow in my light\n[02:39.03]One last sparkle to follow\n[02:42.43]Okay, I didn\'t throw a fit when you said you wanted to leave\n[02:46.38]I told you I loved you, but she didn\'t believe\n[02:50.05]You were too easily fooled, so easily deceived\n[02:54.05]By some dude who\'s more rather into greed\n[02:58.07]Played by your emotions, you were swamped by your needs\n[03:03.90]Told me, I didn\'t believe, you said I was out to deceive, ahaha\n[03:10.61]You said that I lie, how did I?\n[03:14.81]I told you everything, didn\'t I?\n[03:20.10]But you just could not believe... man, I\'m so peeved\n[03:24.86]Your friends all up in your head even when we\'re in bed\n[03:29.52]Your mind\'s elsewhere, and you say you care? Haha\n[03:35.12]I\'m laughing at you all, you think you got me? No, no\n[03:39.03]My back ain\'t against the wall (the wall...)\n[03:43.61]Don\'t let, don\'t let the lifestyle drag you down\n[03:48.57]Who knows when was the last time you felt the love\n[03:53.42]One last sparkle to follow in my light (right on, right on)\n[03:58.33]One last sparkle to follow\n[04:01.68]Source: RCLYRICSBAND.COM'),
(8, 8, '[00:00.000] 作词 : 谷口鮪\n[00:01.000] 作曲 : 谷口鮪\n[00:10.00]踏みつけられた孤独とペダルから\n[00:15.46]何度も鳴り響く音色が頬に伝う\n[00:20.93]打ちつけられた孤独に\n[00:24.62]スネアのリズムが重なって\n[00:28.81]確かな鼓動になる\n[00:31.90]誰か心のノイズをとって\n[00:34.43]わたしを覗いてよ\n[00:37.39]誰も心の奥には入れないけれど\n[00:41.19]期待してしまう　そんな夜\n[00:45.45]Distortion it’s Motion\n[00:47.49]始まったらもう止まらない\n[00:50.93]命題も声帯で震わせられるさ\n[00:54.95]そうだろう\n[00:56.31]ディスコード　いつもそう\n[00:58.38]交わらないその心を繋ぎたい\n[01:02.99]端っこでも\n[01:05.80]\n[01:07.22]投げつけられた言葉が\n[01:10.99]いつまでもなんだか消えないまま\n[01:15.50]夕暮れの影みたいに\n[01:18.23]追いかけられて　止まれば飲み込まれそうで\n[01:24.86]必死で走って　また夜を待つんだ\n[01:29.32]Distortion it’s Motion\n[01:31.04]始まったらもう怖くない\n[01:34.53]騒音と轟音で忘れられるから\n[01:38.70]そうだろう\n[01:39.90]ディスボード　電源を繋ぐ\n[01:42.60]星灯りのように光り出せ\n[01:46.62]わたしだけの音\n[01:48.69]\n[02:01.79]ギターの弦が揺れるたび\n[02:07.22]揺るがないものに変わってゆく\n[02:12.63]指先が硬くなるたび　この意志も固くなるの\n[02:23.95]\n[02:24.97]ディストーションの音色\n[02:27.10]これっぽっちじゃまだ終わらない\n[02:30.42]最前でハイゲインを受け止めてみてよ\n[02:34.55]今夜も\n[02:35.82]Distortion it’s Motion\n[02:37.85]始まったらもう止まらない\n[02:41.37]制限も経験で塗り替えられるさ\n[02:45.58]そうだろう\n[02:46.75]ディストーション　いつもそう\n[02:48.80]左脳追い越して心が走り出す\n[02:53.28]君の方へと\n[02:54.93]次の音にエスコート\n[02:57.72]日々の憂いにディストーション\n[03:00.40]ひとりの夜　鳴らすコード\n[03:03.13]君も同じかい？\n[03:04.59]理想像　追いかけた日々\n[03:07.50]Fコード　掻き鳴らすんだディストーション\n[03:11.30]ボリュームを振り切るよ\n'),
(9, 9, '[00:00.000] 作词 : 樋口愛\n[00:01.000] 作曲 : 音羽-otoha-\n[00:13.14]暗く狭いのが好きだった 深く被るフードの中\n[00:17.99]無情な世界を恨んだ目は どうしようもなく愛を欲してた\n[00:28.13]雨に濡れるのが好きだった 曇った顔が似合うから\n[00:33.15]嵐に怯えてるフリをして 空が割れるのを待っていたんだ\n[00:39.67]かき鳴らせ 光のファズで 雷鳴を 轟かせたいんだ\n[00:49.70]打ち鳴らせ 痛みの先へ どうしよう！ 大暴走獰猛な鼓動を\n[01:09.90]悲しい歌ほど好きだった 優しい気持ちになれるから\n[01:14.86]明るい場所を求めていた だけど触れるのは怖かった\n[01:19.92]深く潜るのが好きだった 海の底にも月があった\n[01:24.91]誰にも言わない筈だった が 歪な線が闇夜を走った\n[01:30.23]かき鳴らせ 交わるカルテット 革命を 成し遂げてみたいな\n[01:40.25]打ち鳴らせ 嘆きのフォルテ どうしよう？ 超奔放凶暴な本性を\n[02:11.07]私 俯いてばかりだ\n[02:14.97]それでいい 猫背のまま 虎になりたいから\n[02:26.40]かき鳴らせ 光のファズで 雷鳴を 轟かせたいんだ\n[02:36.43]打ち鳴らせ 痛みの先へ さあいこう 大暴走獰猛な鼓動を\n[02:46.54]衝動的感情 吠えてみろ！\n[02:49.35]かき鳴らせ\n[02:59.19]雷鳴を');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
CREATE TABLE `playlists` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(100) NOT NULL,
  `playlist_date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`playlist_id`, `playlist_name`, `playlist_date`, `user_id`) VALUES
(1, 'test playlist', '2023-05-07', 2),
(2, 'ww', '2023-05-07', 2),
(3, 'wwww', '2023-05-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `playlist_songs`
--

DROP TABLE IF EXISTS `playlist_songs`;
CREATE TABLE `playlist_songs` (
  `playlist_song_id` int(11) NOT NULL,
  `playlist_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist_songs`
--

INSERT INTO `playlist_songs` (`playlist_song_id`, `playlist_id`, `song_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(4, 3, 2),
(5, 3, 3),
(6, 3, 6),
(7, 3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `song_title` varchar(100) NOT NULL,
  `song_artist` varchar(100) NOT NULL,
  `song_duration` int(11) NOT NULL,
  `song_date` date DEFAULT NULL,
  `song_url` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `cover_url` varchar(255) DEFAULT NULL,
  `song_db_id` varchar(255) DEFAULT NULL,
  `song_view` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `song_title`, `song_artist`, `song_duration`, `song_date`, `song_url`, `category_id`, `cover_url`, `song_db_id`, `song_view`) VALUES
(1, '夜に駆ける', 'YOASOBI', 261041, '2019-12-14', 'bocchibase\\music\\夜に駆ける.mp3', 2, 'bocchibase\\covers\\夜に駆ける_YOASOBI.jpg', '9e3992c7-06d1-4314-8e5c-504992660c8b', 26),
(2, '残酷な天使のテーゼ', '高橋洋子', 247746, '2012-10-01', 'uploads/music/01. 残酷な天使のテーゼ.flac', 3, 'uploads/covers/残酷な天使のテーゼ_高橋洋子.jpg', '22f54ecb-a60f-4ac7-9111-c0d8aacf1f4a', 9),
(3, 'あのバンド', '結束バンド', 213786, '2022-11-27', 'uploads/music/あのバンド.mp3', 2, 'uploads/covers/あのバンド_結束バンド.png', 'a684a206-5237-4169-9a2a-ab590abd8e55', 8),
(4, 'ギターと孤独と蒼い惑星', '結束バンド', 228960, '2022-11-06', 'uploads/music/ギターと孤独と蒼い惑星.mp3', 2, 'uploads/covers/ギターと孤独と蒼い惑星_結束バンド.jpg', 'd23933d6-b48b-4e05-b8ac-e08fdf8fcc9a', 8),
(5, 'Little Dark Age', 'MGMT', 299960, '2018-02-14', 'uploads/music/02 Little Dark Age.flac', 3, 'uploads/covers/Little Dark Age_MGMT.jpg', '1516f9d3-2b29-4851-88f1-44e76b630bc4', 7),
(6, 'Pop Piano Collection, Vol. 7', 'Pianella Piano', 196160, '2021-09-27', 'uploads/music/05. Piano Fantasia - Song For Denise (7\'\' Version).mp3', 3, 'uploads/covers/Song For Denise (7\'\' Version)_Piano Fantasia.jpg', '0ac9d923-c53a-4536-9ab5-636a2d057da2', 11),
(7, 'Believe What I Say', 'Kanye West', 242400, NULL, 'uploads/music/10. Kanye West - Believe What I Say.mp3', 3, 'uploads/covers/Believe What I Say_Kanye West.jpg', '724dc903-3dfb-4837-b54d-6383a2479964', 11),
(8, 'Distortion!!', '結束バンド', 203493, '2022-10-09', 'uploads/music/Distortion!!.mp3', 2, 'uploads/covers/Distortion!!_結束バンド.jpg', 'e7288dcf-dc7a-4ba9-a448-63efa00e459e', 10),
(9, '青春コンプレックス', '結束バンド', 203626, '2022-10-13', 'uploads/music/青春コンプレックス.mp3', 2, 'uploads/covers/青春コンプレックス_結束バンド.jpg', 'd3d8d28e-c4b3-4049-890e-ae57af61732e', 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`) VALUES
(1, 'admin', 'NONE@NONE.COM', '123456', 'admin'),
(2, 'cooluser1', 'test@test.com', '123456', 'user'),
(3, 'coolnice', 'test@test.test', '123456', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

DROP TABLE IF EXISTS `user_likes`;
CREATE TABLE `user_likes` (
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_likes`
--

INSERT INTO `user_likes` (`user_id`, `song_id`) VALUES
(1, 2),
(2, 1),
(3, 2),
(3, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `lyrics`
--
ALTER TABLE `lyrics`
  ADD PRIMARY KEY (`lyrics_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD PRIMARY KEY (`playlist_song_id`),
  ADD UNIQUE KEY `playlist_id` (`playlist_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `category_id` (`category_id`);
ALTER TABLE `songs` ADD FULLTEXT KEY `song_title` (`song_title`,`song_artist`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD PRIMARY KEY (`user_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lyrics`
--
ALTER TABLE `lyrics`
  MODIFY `lyrics_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `playlist_songs`
--
ALTER TABLE `playlist_songs`
  MODIFY `playlist_song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);

--
-- Constraints for table `lyrics`
--
ALTER TABLE `lyrics`
  ADD CONSTRAINT `lyrics_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD CONSTRAINT `playlist_songs_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`),
  ADD CONSTRAINT `playlist_songs_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD CONSTRAINT `user_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_likes_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
