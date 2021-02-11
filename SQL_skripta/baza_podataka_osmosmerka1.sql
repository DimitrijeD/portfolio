-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2020 at 07:38 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza_podataka_osmosmerka1`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `email` varchar(20) NOT NULL,
  `sifra` varchar(64) NOT NULL,
  `t_so` varchar(32) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `pridruzio_se` datetime NOT NULL,
  `tip_korisnika` int(11) NOT NULL,
  `br_zahtevanih_osm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `email`, `sifra`, `t_so`, `korisnicko_ime`, `pridruzio_se`, `tip_korisnika`, `br_zahtevanih_osm`) VALUES
(12, 'димитрије', '2e959eeabc61f0d6d067af3fbdb0c1f4913f153771d4653e2a92a408aacfad68', '1ee346f78e56da27dde3e1de1e166294', 'Димитрије Дракулић', '2020-07-16 15:37:07', 1, 0),
(22, 'dimitrije', 'bcab05c40fb867329c988d0801c1434e0da54aa2f190fbf55b163a37ddafb739', 'c10179a463ddd31834bd0c381edb3157', 'Dimitrije Drakulic1', '2020-08-03 16:57:17', 2, 64),
(51, 'administrator', 'be0b0b47856049ebb259b7b3a4d1dbfee81e68032b264bfd7b069f5f3ff57e34', '9ffa80b634dfd6fdf04e3fc13d72c990', 'administrator', '2020-08-25 07:32:14', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reci_osmosmerke`
--

CREATE TABLE `reci_osmosmerke` (
  `id` int(11) NOT NULL,
  `rec` varchar(20) NOT NULL,
  `brojac_uspesnih_unosa` int(11) DEFAULT 0,
  `brojac_neuspesnih_unosa` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reci_osmosmerke`
--

INSERT INTO `reci_osmosmerke` (`id`, `rec`, `brojac_uspesnih_unosa`, `brojac_neuspesnih_unosa`) VALUES
(12, 'воз', 41, 0),
(13, 'рок', 41, 0),
(14, 'трака', 14, 0),
(15, 'ров', 41, 0),
(16, 'врт', 40, 0),
(17, 'хрт', 40, 0),
(18, 'пат', 41, 0),
(19, 'мат', 41, 0),
(21, 'лак', 40, 0),
(22, 'рак', 40, 0),
(23, 'пак', 40, 0),
(24, 'туп', 42, 0),
(25, 'жут', 41, 0),
(26, 'чип', 41, 0),
(27, 'ћуп', 41, 0),
(28, 'ђак', 40, 0),
(29, 'нем', 41, 0),
(30, 'зло', 43, 0),
(31, 'сто', 45, 0),
(32, 'сир', 40, 0),
(33, 'рис', 40, 0),
(34, 'лењост', 11, 0),
(35, 'успех', 13, 0),
(36, 'вредност', 7, 0),
(37, 'крај', 20, 0),
(38, 'штап', 22, 0),
(39, 'шупа', 21, 0),
(40, 'штака', 14, 0),
(41, 'поштење', 6, 0),
(42, 'лопов', 14, 0),
(43, 'ваздух', 11, 0),
(44, 'храна', 14, 0),
(45, 'трава', 14, 0),
(46, 'потреба', 6, 0),
(47, 'пресвлака', 5, 0),
(48, 'наруџбина', 5, 0),
(49, 'џак', 40, 0),
(50, 'оџак', 24, 0),
(51, 'чварак', 10, 0),
(52, 'правда', 9, 0),
(53, 'правичност', 3, 0),
(54, 'оправдање', 5, 0),
(55, 'захтев', 11, 0),
(56, 'планина', 6, 0),
(57, 'паштета', 6, 0),
(58, 'градиво', 6, 0),
(59, 'помиловање', 4, 0),
(60, 'руковање', 7, 0),
(61, 'књижевност', 3, 0),
(62, 'лукавост', 6, 0),
(63, 'особа', 16, 0),
(64, 'постојање', 4, 0),
(65, 'застава', 6, 0),
(66, 'зрелост', 6, 0),
(67, 'живот', 13, 0),
(68, 'журка', 13, 0),
(69, 'пожурити', 6, 0),
(70, 'хладноћа', 5, 0),
(71, 'топлина', 6, 0),
(72, 'топло', 14, 0),
(73, 'хладно', 9, 0),
(74, 'граница', 5, 0),
(75, 'истина', 9, 0),
(76, 'лаж', 41, 0),
(77, 'оптерећење', 3, 0),
(78, 'теорема', 6, 0),
(79, 'теорија', 6, 0),
(80, 'владавина', 4, 0),
(81, 'пожртвовање', 3, 0),
(82, 'боца', 20, 0),
(83, 'посуда', 10, 0),
(84, 'кашика', 10, 0),
(85, 'виљушка', 9, 0),
(86, 'нож', 41, 0),
(87, 'тањир', 14, 0),
(88, 'чинија', 9, 0),
(89, 'лонац', 14, 0),
(90, 'рерна', 13, 0),
(91, 'цевчица', 7, 0),
(92, 'кутлача', 6, 0),
(93, 'вода', 20, 0),
(94, 'река', 21, 0),
(95, 'риба', 20, 0),
(96, 'пецање', 10, 0),
(97, 'удица', 13, 0),
(98, 'најлон', 11, 0),
(99, 'спојница', 6, 0),
(100, 'олово', 16, 0),
(101, 'шума', 20, 0),
(102, 'комарац', 6, 0),
(103, 'фарба', 13, 0),
(104, 'фризби', 9, 0),
(105, 'гравитација', 3, 0),
(106, 'губитак', 6, 0),
(107, 'даровати', 5, 0),
(108, 'разбити', 6, 0),
(109, 'хранити', 6, 0),
(110, 'хватати', 5, 0),
(111, 'јечам', 13, 0),
(112, 'кукуруз', 5, 0),
(113, 'хлеб', 20, 0),
(114, 'пахуљица', 5, 0),
(115, 'мрвица', 9, 0),
(116, 'стабло', 9, 0),
(117, 'лист', 21, 0),
(118, 'корен', 15, 0),
(119, 'кора', 22, 0),
(120, 'столица', 6, 0),
(121, 'монитор', 7, 0),
(122, 'миш', 40, 0),
(123, 'кафа', 22, 0),
(124, 'оловка', 10, 0),
(125, 'упаљач', 10, 0),
(126, 'сијалица', 4, 0),
(127, 'светло', 10, 0),
(128, 'зид', 40, 0),
(129, 'ћумур', 14, 0),
(130, 'расвета', 7, 0),
(131, 'село', 21, 0),
(132, 'град', 21, 0),
(133, 'држава', 10, 0),
(134, 'провинција', 3, 0),
(135, 'историја', 6, 0),
(136, 'биологија', 4, 0),
(137, 'математика', 3, 0),
(138, 'технологија', 3, 0),
(139, 'категорија', 4, 0),
(140, 'чуло', 21, 0),
(141, 'мирис', 14, 0),
(142, 'додир', 15, 0),
(143, 'вид', 41, 0),
(144, 'слух', 20, 0),
(145, 'осећај', 9, 0),
(146, 'струја', 10, 0),
(147, 'утичница', 5, 0),
(148, 'кревет', 9, 0),
(149, 'јастук', 10, 0),
(150, 'тренерка', 6, 0),
(151, 'дукс', 20, 0),
(153, 'посао', 13, 0),
(155, 'слабост', 6, 0),
(156, 'интуиција', 3, 0),
(157, 'шах', 40, 0),
(158, 'фигура', 10, 0),
(159, 'поље', 21, 0),
(160, 'пијун', 13, 0),
(161, 'топ', 41, 0),
(162, 'скакач', 9, 0),
(163, 'ловац', 13, 0),
(164, 'краљица', 7, 0),
(165, 'краљ', 20, 0),
(166, 'лопта', 14, 0),
(167, 'кошарка', 6, 0),
(168, 'фудбал', 9, 0),
(169, 'стадион', 6, 0),
(170, 'трибине', 6, 0),
(171, 'тенис', 13, 0),
(172, 'одбојка', 6, 0),
(173, 'рукомет', 7, 0),
(174, 'позадина', 5, 0),
(175, 'крштење', 6, 0),
(176, 'обједињавање', 4, 0),
(177, 'објашњење', 4, 0),
(178, 'обустава', 5, 0),
(179, 'карантин', 6, 0),
(180, 'спреј', 13, 0),
(181, 'марамица', 5, 0),
(182, 'кабл', 22, 0),
(183, 'каиш', 21, 0),
(184, 'душек', 13, 0),
(185, 'канта', 13, 0),
(186, 'пловак', 10, 0),
(187, 'мачка', 13, 0),
(188, 'пас', 41, 0),
(189, 'овца', 20, 0),
(190, 'крава', 13, 0),
(191, 'радијатор', 4, 0),
(192, 'уређај', 9, 0),
(193, 'осмосмерка', 3, 0),
(194, 'радијација', 3, 0),
(195, 'разбојник', 4, 0),
(196, 'сателит', 6, 0),
(197, 'пројекат', 5, 0),
(198, 'летелица', 5, 0),
(199, 'авион', 15, 0),
(200, 'почетник', 5, 0),
(201, 'микрофон', 6, 0),
(202, 'звучник', 6, 0),
(203, 'квантитет', 4, 0),
(204, 'квалитет', 5, 0),
(205, 'ограда', 9, 0),
(206, 'мотика', 9, 0),
(207, 'забрана', 6, 0),
(208, 'фабрика', 6, 0),
(211, 'обезбеђење', 4, 0),
(212, 'обесхрабљење', 4, 0),
(213, 'узбуђење', 6, 0),
(214, 'адвокатура', 3, 0),
(215, 'преузимање', 3, 0),
(216, 'поступање', 4, 0),
(217, 'захваљење', 4, 0),
(218, 'превлачење', 3, 0),
(219, 'забринутост', 4, 0),
(220, 'збуњивати', 3, 0),
(221, 'збуњивајуће', 3, 0),
(222, 'прекратити', 3, 0),
(223, 'пресећи', 6, 0),
(224, 'привлачење', 3, 0),
(225, 'привући', 6, 0),
(226, 'скретање', 4, 0),
(227, 'поветарац', 3, 0),
(228, 'оглашавање', 3, 0),
(229, 'спашавање', 4, 0),
(230, 'претрпети', 4, 0),
(231, 'преболети', 4, 0),
(232, 'приступити', 3, 0),
(233, 'препречити', 3, 0),
(234, 'одстранити', 3, 0),
(235, 'укратити', 5, 0),
(236, 'прекорачити', 3, 0),
(237, 'ускратити', 7, 0),
(238, 'обавестити', 3, 0),
(239, 'обавештење', 3, 0),
(240, 'обавештавати', 4, 0),
(241, 'одбацити', 5, 0),
(242, 'окачити', 6, 0),
(244, 'праћка', 9, 0),
(245, 'упозорење', 4, 0),
(246, 'запослити', 3, 0),
(247, 'жаба', 21, 0),
(248, 'превозити', 3, 0),
(249, 'спавање', 7, 0),
(250, 'телефон', 5, 0),
(251, 'олуја', 14, 0),
(252, 'падавине', 5, 0),
(253, 'празници', 5, 0),
(254, 'санкција', 6, 0),
(256, 'заобилазак', 4, 0),
(257, 'прекретница', 3, 0),
(258, 'врхунац', 8, 0),
(259, 'џеп', 42, 0),
(260, 'ходочашће', 3, 0),
(261, 'боровница', 5, 0),
(262, 'шраф', 20, 0),
(263, 'прекривач', 4, 0),
(264, 'шпагете', 6, 0),
(265, 'преображај', 3, 0),
(266, 'препоручити', 3, 0),
(267, 'јама', 21, 0),
(268, 'ходање', 10, 0),
(272, 'метаморфоза', 3, 0),
(276, 'књига', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resene_osmosmerke`
--

CREATE TABLE `resene_osmosmerke` (
  `id` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `reci_osmosmerke` varchar(255) NOT NULL,
  `niz_osmosmerke` varchar(255) NOT NULL,
  `unet_red` int(11) NOT NULL,
  `unet_kolona` int(11) NOT NULL,
  `resenje_osmosmerke` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resene_osmosmerke`
--

INSERT INTO `resene_osmosmerke` (`id`, `id_korisnika`, `reci_osmosmerke`, `niz_osmosmerke`, `unet_red`, `unet_kolona`, `resenje_osmosmerke`) VALUES
(12, 1, 'вид/зид/миш/ров/', 'ovde trebaju biti putevi', 3, 3, 'nema resenje'),
(14, 1, 'џеп/ћуп/џак/нем/', 'ovde trebaju biti putevi', 3, 3, 'nema resenje'),
(17, 22, 'рак/рок/ров/', 'ovde trebaju biti putevi', 3, 3, 'nema resenje'),
(18, 22, 'врт/хрт/топ/', 'ovde trebaju biti putevi', 3, 3, 'nema resenje'),
(19, 22, 'шах/вид/дукс/чип/пат/каиш/', 'ovde trebaju biti putevi', 4, 4, 'nema resenje'),
(20, 22, 'посуда/чинија/зид/укратити/миш/нож/štuka/жут/особа/фабрика/воз/џеп/канта/шупа/чип/олуја/сто/чварак/врт/спреј/шума/рис/мат/нем/зло/туп/сир/', 'ovde trebaju biti putevi', 10, 10, 'ПРЕВОЗИТИ'),
(21, 22, 'монитор/лењост/џак/јечам/летелица/корен/оџак/лопов/позадина/збуњивајуће/најлон/лукавост/олово/крава/ђак/пас/дукс/оловка/ћумур/пецање/топло/шупа/превозити/боца/препречити/пловак/столица/фудбал/ходање/ћуп/топ/шах/вода/цевчица/шраф/расвета/каиш/вид/краљ/жут/', 'ovde trebaju biti putevi', 20, 20, 'nema resenje'),
(22, 22, 'осећај/џак/успех/џеп/сто/', 'ovde trebaju biti putevi', 3, 6, 'nema resenje'),
(23, 22, 'вид/ђак/зид/', 'ovde trebaju biti putevi', 3, 3, 'nema resenje'),
(24, 22, 'ћуп/топ/пас/', 'ЋУП_ОАТ_С', 3, 3, 'nema resenje'),
(25, 22, 'миш/књижевност/чуло/кафа/ловац/хрт/нож/празници/лак/рак/пак/вредност/лаж/оџак/зло/штака/губитак/одбојка/риба/чип/дукс/сто/кабл/шах/џак/село/жут/рок/', '_НГУБИТАКЛЗЛОДБОЈКАСКБКЖМПОЖРЕАААБИРАКАЛЏКФЧШДУКСООПРАЗНИЦИХЖУТСОНДЕРВОЛУЧАКАТШОКЊИЖЕВНОСТХАШЦАВОЛ_С', 10, 10, 'nema resenje'),
(26, 22, 'тенис/пресвлака/лист/правда/лонац/поље/пресећи/воз/пловак/уређај/краљ/сир/додир/авион/миш/риба/рис/виљушка/рак/пат/пак/џеп/боца/река/вид/зло/лак/сто/', 'КСТОПНБОЦАААКЕРПОЉЕППРЕСЕЋИИР_ВОЗЏСИРАВЈРИБАВИВА_АИЛДЦЛДНСКЂДИАЉАРКЕИЕОСМККНЗ_ТРДТИКАВОЛПУАКШУЉИВЛО_', 10, 10, 'ВОДА'),
(27, 22, 'вода/интуиција/обједињавање/стадион/трака/успех/канта/јама/кутлача/ограда/олуја/позадина/пецање/светло/ускратити/пахуљица/шупа/лаж/шраф/рукомет/марамица/лонац/рерна/лопов/оправдање/крај/ђак/тањир/краљица/ћумур/падавине/струја/сто/удица/технологија/збуњива', 'ТВОРИДОД__ИТИТАРКСУТАЧАЛТУК_ПАДАВИНЕТДОХПДИЗЛШТЕТИЛАВКИАИПУАТ_ПААКЊ__ЦКРРШДЦЛЛЗБЕАОХКАНТАОИИЛИАОСОБАХЈТТЦББНРЊБСОАЗП_АУЖНИПЕЏЛООАА_НПКОРЕНЊАОГПВ_ЛЦТЦОККОЕПАЊИИНЛОУТАМАСИЛААВРАВАБВРОЛТСАПВУМЗЏОЖУЦДВЏАЕГО__ШЕСМАДОЛУМИААУТРИИ_РТП_ЛРИАУТУЉЊЊРИУЈБАЛЕСИ_АВЈЈ_ЋУ', 20, 20, 'nema resenje'),
(28, 22, 'слабост/лаж/ђак/мотика/шах/скретање/микрофон/корен/утичница/поветарац/теорема/обавештавати/забринутост/ћуп/овца/даровати/посао/ров/квантитет/кашика/поступање/журка/објашњење/вода/прекривач/прекорачити/санкција/слух/врт/претрпети/чинија/празници/оглашавање', 'ЛУКАВОСТТАЈ__КЕ_ОСЕЋАЈ_АЦИЉАРК_К_АПА__О___ВИД__ИВА_МОЊАДППЛАНИНА_Х_А__А_МАЦЛ__С____А_ЦЛАЂ_ИБА_СР__И__ЋБЕЛХК__Ш_ЕДИ__ОКО___ПДАЕРЕ_ТЕП_ТЕ_ААС_УКРАТИТИИЛРАНОК_ОВБ__А_ВТКР_ИСУ_РО_СКНТП__Д_А__КООВАТ_ВРД_А_К_ОАШУ_БХТЖАБАПЈТЕТИТНАВК_АНЕИРОВ_АИО__КОЛСР_ТЗРС_НР__О', 40, 40, 'nema resenje'),
(29, 22, 'препоручити/овца/пожртвовање/обустава/пожурити/лаж/обједињавање/вода/мотика/гравитација/спашавање/ђак/поштење/село/поветарац/монитор/корен/окачити/шах/обавестити/кашика/обесхрабљење/пас/технологија/обавештавати/оптерећење/трибине/поступање/слабост/кукуруз', 'ЗБУЊИВАЈУЋЕА_____А___АП_КОА__А__ФИГУРАОБЕЗБЕЂЕЊЕТ___ЕЊАВАШАЛГОЦ__О___Ј__К_Р_Р_ПК_ПЦАНИНАЛП_________ОП___ПРОЈЕКАТАИ_А_БП__И_И_ЛЕАЕ_ОРР_ОИ_УСКРАТИТИИ___ПИ___Ј______МЧЛЦН__А___ЦШ_И_КЦВРИБАЕ_ШН__И______Н___Ч____АА____А_А_ИИ_СВ__АА_С__РИЕЧ___ВН_ТЧ__ТИТЕПРТЕРПК', 52, 52, 'nema resenje'),
(30, 22, 'обустава/мотика/поштење/корен/кашика/монитор/лаж/ђак/скакач/лењост/марамица/шах/посао/одбацити/окачити/вода/ћуп/ров/ходање/математика/врт/хладноћа/јастук/кафа/стабло/кабл/посуда/овца/краљ/мачка/трибине/пас/хрт/чип/чуло/тањир/теорија/крава/лонац/светло/сир', 'А__АНАРХ__ЕНИБИРТАК_М__АТТТВАЗДУХКЖАД_Е_А_ЦАОТСЕЛООВЦААУЦКШПЈОЊЛВР_ОТОПЛОЋСЏРИУИБИУ_КАФАЊШНСПОСАОКДЧРЧ_ЏАКТ_ЈЕААПНЉ__ААУ_ЈКАЛАЂСРИЛПЦДТ__ККРЏОЕК__АОУ_РОФАРШАИИРЕЛДЧАВКЛКБВОПЛ_КБТТОПБШИАИРАОООИТХС_ООАТОААНЗМШЕЛВД_ДС_ПСММИТТХИРИДОДБАЦИТИООМЕНЖСЛЈККАБЛН_ЦПУЋ', 20, 20, 'nema resenje'),
(31, 22, 'лаж/мат/шах/пас/', 'СМЖХАШЛТП', 3, 3, 'nema resenje'),
(32, 22, '', '_______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________', 20, 20, 'nema resenje'),
(33, 22, 'зид/чип/сир/рис/', 'ПСДРИСЗРЧ', 3, 3, 'nema resenje'),
(34, 22, 'спашавање/обједињавање/овца/препоручити/поље/скретање/вода/интуиција/хранити/објашњење/упаљач/хватати/крај/привући/пијун/оловка/виљушка/удица/жут/пожртвовање/тенис/обесхрабљење/лукавост/нем/застава/боца/обавестити/мирис/живот/олуја/ограда/ђак/провинција/с', 'ПРЕВОЗИТИК_ХМАРАМИЦАУПАЉАЧ_К__О_АВ_АДВАРПКР_ЗАСТАВААТЕВСАРПКБ_ЦЗ_О_БК___РАТП__С__КЊЕ__ИААРААЛЗББЛ_ИСТИНАН_РЕЉОПАРИЊАТВКЕВО_ОТИ_ИНТУИЦИЈАДОВ_ВРИС_ЕИА_ВЕ__ВСЛТПТ__ТСОНДЕРВА_АСКРЕТАЊЕШ_П_ИАЕИЕ_ПЛОВАК__ПИИВКК__АШ_ТТШО_ЛЗ_ЊЧЏЛАБДУФ_С_ТНЧ_УА_РШООЕАМО_АКВОЛОМЈУТ', 30, 30, 'nema resenje'),
(35, 22, 'овца/праћка/жут/звучник/узбуђење/оптерећење/прекратити/врхунац/пројекат/пијун/поље/тенис/стабло/ров/обезбеђење/вода/мрвица/упозорење/олуја/ћуп/захтев/врт/успех/слух/санкција/спојница/ђак/пат/топ/авион/превлачење/нож/туп/хрт/воз/шупа/рок/чуло/зло/село/лак/', 'УОАРАК_ПРЕКРАТИТИ____ППКАЏО_А_Њ_ТРВУ_ША_АЈОТАЛ_АБИРЕ_ДС_ЗИДКМ_АЗЕРМ_АЕ_ВЂПОВЦАОРУР_СОРТРЖСЛРЕЕАДОКВАШЗЕЂТРЕЕВОКХИЊБСИЛ_В__БКАУЕЋНИНУКСАЗЋРУАТСЕУАККЊЕИЦНДАОВЕУОЧФСЛЉЂРОТЕЊСАНЛБСАБПВ_ИОУОЕАЛ_ЖЕЦУЕКЛОПОВЈТГНХПЊВОИ__ЈЊОАЛБСПСАТУВ_ЗЕЧВСРИОРКИТАРШКРАРЕОА_ООППСА', 20, 20, 'nema resenje'),
(36, 22, 'жут/ров/уређај/ћумур/ходање/ловац/звучник/ћуп/врт/храна/ђак/топ/корен/цевчица/нож/олово/сир/туп/хрт/лопта/кафа/нем/пат/поље/лаж/чип/шах/зид/зло/лак/рок/', 'НЕРОКЦЈ_КЗКШАХРАНАИЛКАФАЂВЛДНАРОЂЕЉОПХЧЖЗУРИСЛОЋУТЛУМЕНДУТВАОТХУАПИЧЗППРРЊЋ_НОЖОТЦЕВЧИЦА_ТАТУПОЛОВОР', 10, 10, 'ВОЗ'),
(37, 22, 'упаљач/зрелост/трава/воз/шраф/нож/спреј/објашњење/оловка/шах/сто/кафа/краљ/ђак/душек/пас/топ/особа/жаба/џак/кора/поље/шупа/штап/рак/пак/јама/туп/ров/пат/врт/мат/', '_КАЏЕЉОПМЖ_ЗАМАЈБСАПЈРТРВФЈБТЗЂЕКЧАЉАПУОАЛРБР_ШКПВКООПТДЊП_ТВСФ_СУЕАНАОТАПУШЊТОП_АРОКЕЕШЖ_ХАШПАКВОЛО', 10, 10, 'ЗАБРАНА'),
(38, 22, 'хрт/оглашавање/пецање/миш/ћуп/укратити/летелица/овца/журка/поветарац/квалитет/забрана/позадина/лукавост/жут/пожурити/уређај/вода/риба/гравитација/карантин/захтев/мачка/преболети/чуло/слух/вид/крај/најлон/микрофон/лист/празници/село/тенис/одбацити/воз/куку', '_АНРЕР_____ЛОНАЦИНЧИТУЗБУЂЕЊЕАРУКОВАЊЕ_К_МУ_КС___НЕРОКАЧИТИВШ___АБАЖ_ЕПАД_Е_Т_МОТИКА_М__НАРАСЛАБОСТШОЧИ_РУОР_ОСЕЋАЈЏУО_РАБИ_ЧАЉАПУСКЦ__ДРКУКУРУЗЕ_ЛШПТФОНЕПЦВРТДУААОБЧАЕ_ЈИ__П_ЈЈЕАА_СЕЉРОПОЗАДИНАЛЏВ_Ђ_АТ_ШААЦЊННУОТОАБЈАМААДЦУОБКАРАНТИНСА_АИИ_СМПЋ_ПСТАДИОНЈ', 30, 30, 'nema resenje'),
(39, 22, 'хрт/сто/рис/зло/', 'ОТСЛРИЗХР', 3, 3, 'nema resenje'),
(40, 22, 'ћуп/жут/туп/топ/', 'ПЖПОУ_ТТЋ', 3, 3, 'nema resenje'),
(41, 22, 'вид/ров/рис/миш/', 'СШВ_ИОДМР', 3, 3, 'nema resenje'),
(42, 22, 'градиво/кошарка/сир/овца/канта/воз/мат/лак/рок/мачка/кора/олово/храна/ваздух/кафа/зло/нож/ров/вода/трава/корен/чуло/шах/врт/хрт/рак/вид/град/држава/пат/лаж/миш/оџак/сто/', 'ДРЖАВАРТ_ДРТРВКОРЕНАВАЗДУХДЛКРО_КОВИДАРГЗЛОААПФЖОНМИШННАОВЦА_АААСТОЛИ_ХРРИСЛАКУДХОКВОРТРХЧКТАМАЧКАЏО', 10, 10, 'СЛУХ'),
(43, 22, 'џеп/пас/пак/џак/ћуп/ђак/', 'П_КЂАЕАЋККЏУ_САП', 4, 4, 'nema resenje'),
(44, 22, 'нем/зид/жут/воз/сто/лаж/', '_ЛАЖДСУНИТ_ЕЗОВМ', 4, 4, 'nema resenje'),
(45, 22, 'џеп/џак/пас/село/туп/лист/', 'СТОКАУЛАППЕЏЛИСТ', 4, 4, 'nema resenje'),
(46, 22, 'нем/мат/миш/', 'ШИМ_ЕАН_Т', 3, 3, 'nema resenje'),
(47, 22, 'краљица/даровати/пахуљица/слух/технологија/пожурити/пецање/крај/журка/чуло/фарба/рерна/привлачење/скретање/овца/краљ/шраф/хранити/истина/тенис/боца/сателит/светло/комарац/трибине/забринутост/квантитет/уређај/ћумур/кашика/пијун/разбојник/нож/душек/потреба/', 'СК_ОНДАЛХШС_ЛИСТС__Х__УТИЧНИЦАКАШИКААШТАА_АФ___ВЕМЕТАМОРФОЗАРРИБАБАУОХТ_КАД__ПЕ__Ж__УПАЉАЧЕАК_АЦАМВ_ЕТШРУ_СКМТУ___РБ_Т__ТВРЖИТБАИСЛАУБКУИ_ИРЛВ_ААЕ_Е__АЧЕЧ_ХЕЕЖЕИМЉАСНСНК_ООЋДТЛ_Т__Њ_В_ПХРХЉЛТРИ_ЈАТАРП_КАТНХАИПЖЕЕЕААРТТНОЛОВОЈХОЈОКАРР_А_ЈТРУЦРТ_ЦАО_ПОП_БИ_', 30, 30, '/'),
(48, 22, 'пак/лак/ђак/лаж/', 'ККЖАААЂПЛ', 3, 3, '/'),
(49, 22, 'слух/рак/летелица/захваљење/врт/фризби/скакач/крај/краљ/зрелост/најлон/корен/чинија/вид/зид/хрт/кашика/фудбал/овца/жут/каиш/чип/светло/лонац/журка/ћуп/рерна/шраф/боца/хлеб/лак/џеп/руковање/пас/тањир/вода/топ/лопов/олуја/пак/шах/жаба/лист/рок/сир/лењост/ри', 'И__КАЏААААБИР_ЗСС_ЂКТШКН_РЦЦЖВЛЛОР_И_ХАШАУТАООИПОЧОАЕСРРДФКАТМСКБЛ_ЕНПИРБЗОВАЗБНААОАЕЛЈЦТ_НП_ДАБАРЕ_ВНЛТСИЛАЧАКАКСУХАМАТХ_ЕШКЉРЊНАР_Ж_ВФТТ__СЛРР_А_ЕЏОЛЕСА__РЕФА_ТЗИОРРОКЋУПЉАБХААВПЛ_ОЊ_КУ_ФА_Е_АПАР__УЕП_АП_К__РЊТЦ_АШУПНШЊЛЕТА_ООЖЕИИОЗЈ_ГУУАО_ОЏТДВЖ_ИЉЗЛПУ', 20, 20, '/'),
(50, 22, 'рак/рок/ров/топ/', 'Р_ВТОПРАК', 3, 3, '/'),
(51, 22, 'преболети/кревет/претрпети/јечам/врт/хрт/граница/слух/поступање/упозорење/пројекат/прекретница/ћуп/разбити/чинија/успех/наруџбина/чип/кукуруз/обједињавање/забринутост/зид/обесхрабљење/праћка/жут/крај/спојница/микрофон/удица/марамица/математика/посао/мотик', '__А__АКИШАК_____УПАЉАЧ___ЕНАТЕТШАПКУТСАЈ___Д__Ш___ЦАВАРТ_Л_АВАРКЊИИ_Т_РХЛАДНОЋАТИ_ОЏВТАНРЕРОВОЛООА__РИЊАТТ_Р_А_ЧЛУКАВОСТТТЕБААХ_ВН_КФ_ДНПП__К_ДНИАА_Ф__И_К__ШИ__АПИКАУРЧ__ААИ_ААРУЕМ_ВАТОКК_ИТИНАРХУЛ___В_АТЛВИП__ПРГЦ_ОЕШИЊАРА_АД_ЕПАЦИДУМ__ПВ_А__САЦЕ___ОАУ__', 40, 40, '/'),
(52, 22, 'врт/вид/хрт/туп/', 'ТТДУРИПХВ', 3, 3, '/'),
(53, 22, '', '_________', 3, 3, ''),
(54, 22, '', '_________', 3, 3, ''),
(55, 22, '', '_________', 3, 3, ''),
(56, 22, '', '_________', 3, 3, ''),
(57, 22, 'ћуп/чип/жут/', 'ПЖЋИУУЧТП', 3, 3, '/'),
(59, 22, 'слух/нем/џеп/ћуп/чуло/туп/жут/нож/мат/сто/', 'ОТСЧТСЖУТАЖЛЏПМООУЕ__ЋНХП', 5, 5, '/');

-- --------------------------------------------------------

--
-- Table structure for table `sesije_korisnika`
--

CREATE TABLE `sesije_korisnika` (
  `id` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `t_hes` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vrste_korisnika`
--

CREATE TABLE `vrste_korisnika` (
  `id` int(11) NOT NULL,
  `naziv_tipa` varchar(20) NOT NULL,
  `ovlascenje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vrste_korisnika`
--

INSERT INTO `vrste_korisnika` (`id`, `naziv_tipa`, `ovlascenje`) VALUES
(1, 'Obicni korisnik', ''),
(2, 'Administrator', '{\"admin\": 1}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reci_osmosmerke`
--
ALTER TABLE `reci_osmosmerke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resene_osmosmerke`
--
ALTER TABLE `resene_osmosmerke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_korisnika` (`id_korisnika`);

--
-- Indexes for table `sesije_korisnika`
--
ALTER TABLE `sesije_korisnika`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_korisnika` (`id_korisnika`);

--
-- Indexes for table `vrste_korisnika`
--
ALTER TABLE `vrste_korisnika`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `reci_osmosmerke`
--
ALTER TABLE `reci_osmosmerke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `resene_osmosmerke`
--
ALTER TABLE `resene_osmosmerke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `sesije_korisnika`
--
ALTER TABLE `sesije_korisnika`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vrste_korisnika`
--
ALTER TABLE `vrste_korisnika`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `resene_osmosmerke`
--
ALTER TABLE `resene_osmosmerke`
  ADD CONSTRAINT `resene_osmosmerke_ibfk_1` FOREIGN KEY (`id_korisnika`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sesije_korisnika`
--
ALTER TABLE `sesije_korisnika`
  ADD CONSTRAINT `sesije_korisnika_ibfk_1` FOREIGN KEY (`id_korisnika`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
