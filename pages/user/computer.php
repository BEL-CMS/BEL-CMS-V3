<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
    $hardware = $_SESSION['USER']->hardware;
?>
<section id="section_user">
<?php require 'menu.php'; ?>
    <form action="User/sendComputer" id="section_user_computer" method="post">
        <div class="section_user_computer">
            <div class="section_user_computer_row">
                <label for="connect">Choisir sa connexion</label>
                <select id="connect" name="internet_connection">
                    <option selected value="<?=$hardware->internet_connection;?>"><?=$hardware->internet_connection;?></option>
                    <option value="Modem 56K">Modem 56K</option>
                    <option value="Modem 128">Modem 128K</option>
                    <option value="ADSL 128K">ADSL 128K</option>
                    <option value="ADSL 512">ADSL 512K</option>
                    <option value="ADSL 1024K">ADSL 1024K</option>
                    <option value="ADSL 2048K">ADSL 2048K</option>
                    <option value="ADSL 3M">ADSL 3M</option>
                    <option value="ADSL 4M">ADSL 4M</option>
                    <option value="ADSL 5M">ADSL 5M</option>
                    <option value="ADSL 8M">ADSL 8M</option>
                    <option value="ADSL 20M +">ADSL 20M +</option>
                    <option value="Cable 128K">Cable 128K</option>
                    <option value="Cable 512K">Cable 512K</option>
                    <option value="Cable 1024K">Cable 1024K</option>
                    <option value="Cable 2048K">Cable 2048K</option>
                    <option value="Cable 8M">Cable 8M</option>
                    <option value="Cable 20M +">Cable 20M +</option>
                    <option value="T1 1,5M">T1 1,5M</option>
                    <option value="T2 6M">T2 6M</option>
                    <option value="T3 45M">T3 45M</option>
                    <option value="Fibre 50M">Fibre 50M</option>
                    <option value="Fibre 100M">Fibre 100M</option>
                    <option value="Fibre 1000 Mbps">Fibre 1000 Mbps</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="tower">Choisir sa tour</label>
                <select id="tower" name="tower" class="form-control">
                    <option selected value="<?=$hardware->tower;?>"><?=$hardware->tower;?></option>
                    <option value="Génerique">Génerique</option>
                    <option value="Aerocool">Aerocool</option>
                    <option value="Asus">Asus</option>
                    <option value="Be Quiet">Be Quiet</option>
                    <option value="Bitfenix">Bitfenix</option>
                    <option value="Cooler Master">Cooler Master</option>
                    <option value="Corsair">Corsair</option>
                    <option value="Deepcool">Deepcool</option>
                    <option value="Enermax">Enermax</option>
                    <option value="Fractal Design">Fractal Design</option>
                    <option value="Inwin">Inwin</option>
                    <option value="Kolink">Kolink</option>
                    <option value="Lianli">Lianli</option>
                    <option value="Msi">Msi</option>
                    <option value="Nzxt">Nzxt</option>
                    <option value="MarsGaming">MarsGaming</option>
                    <option value="PNY">PNY</option>
                    <option value="Phanteks">Phanteks</option>
                    <option value="Thermaltake">Thermaltake</option>
                    <option value="Xigmatek">Xigmatek</option>
                    <option value="Zalman">Zalman</option>
                    <option value="Spire">Spire</option>
                    <option value="Advance">Advance</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="keyboard">Choisir son clavier</label>
                <select id="keyboard" name="keyboard" class="form-control">
                    <option selected value="<?=$hardware->keyboard;?>"><?=$hardware->keyboard;?></option>
                    <option value="Génerique">Génerique</option>
                    <option value="The G-Lab">The G-Lab</option>
                    <option value="Logitech">Logitech</option>
                    <option value="ASUS">ASUS</option>
                    <option value="ASUS ROG">ASUS ROG</option>
                    <option value="Cooler Master">Cooler Master</option>
                    <option value="Razer">Razer</option>
                    <option value="Trust">Trust</option>
                    <option value="TECURS">TECURS</option>
                    <option value="SteelSeries">SteelSeries</option>
                    <option value="Mobility LAB">Mobility LAB</option>
                    <option value="Geeky">Geeky</option>
                    <option value="Mars Gaming">Mars Gaming</option>
                    <option value="EMPIRE GAMING">EMPIRE GAMING</option>
                    <option value="EPOMAKER">EPOMAKER</option>
                    <option value="Rii">Rii</option>
                    <option value="Dell">Dell</option>
                    <option value="Corsair">Corsair</option>
                    <option value="MSI">MSI</option>
                    <option value="KEMOVE">KEMOVE</option>
                    <option value="RedThunder">RedThunder</option>
                    <option value="APM">APM</option>
                    <option value="ATTACK SHARK">ATTACK SHARK</option>
                    <option value="Glorious">Glorious</option>
                    <option value="perixx">perixx</option>
                    <option value="HK GAMING">HK GAMING</option>
                    <option value="SOLIDEE">SOLIDEE</option>
                    <option value="Dierya">Dierya</option>
                    <option value="YUNZII">YUNZII</option>
                    <option value="Kensington">Kensington</option>
                    <option value="MAGIC-REFINER">MAGIC-REFINER</option>
                    <option value="YINDIAO">YINDIAO</option>
                    <option value="Cherry">Cherry</option>
                    <option value="Turtle Beach">Turtle Beach</option>
                    <option value="BAKTH">BAKTH</option>
                    <option value="HyperX">HyperX</option>
                    <option value="Ranked">Ranked</option>
                    <option value="Snpurdiri">Snpurdiri</option>
                    <option value="Mobility Lab">Mobility Lab</option>
                    <option value="AD Advance">AD Advance</option>
                    <option value="NEWWAY">NEWWAY</option>
                    <option value="Apple">Apple</option>
                    <option value="iClever">iClever</option>
                    <option value="Redragon" >Redragon</option>
                    <option value="Bluestork">Bluestork</option>
                    <option value="Macally">Macally</option>
                    <option value="Spirit Of Gamer">Spirit Of Gamer</option>
                    <option value="Mcbazel">Mcbazel</option>
                    <option value="HP">HP</option>
                    <option value="ZIYOU">ZIYOU</option>
                    <option value="Advance">Advance</option>
                    <option value="OMOTON">OMOTON</option>
                    <option value="Highspirit">Highspirit</option>
                    <option value="Ducky">Ducky</option>
                    <option value="Roccat">Roccat</option>
                    <option value="Yamaha">Yamaha</option>
                    <option value="LQXQ">LQXQ</option>
                    <option value="Ovegna">Ovegna</option>
                    <option value="Ewent">Ewent</option>
                    <option value="Hama">Hama</option>
                    <option value="SinLoon">SinLoon</option>
                    <option value="Nova">Nova</option>
                    <option value="LexonElec">LexonElec</option>
                    <option value="Microsoft">Microsoft</option>
                    <option value="TiMOVO">TiMOVO</option>
                    <option value="PINKCAT">PINKCAT</option>
                    <option value="Mobility Lab">Mobility Lab</option>
                    <option value="LeadsaiL">LeadsaiL</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="cooling">Refroidissement</label>
                <select id="cooling" name="cooling" class="form-control">
                    <option selected value="<?=$hardware->cooling;?>"><?=$hardware->cooling;?></option>
                    <option value="Origine">Origine</option>
                    <option value="Asus">Asus</option>
                    <option value="Be Quiet">Be Quiet</option>
                    <option value="Corsair">Corsair</option>
                    <option value="Cooler Master">Cooler Master</option>
                    <option value="Msi">Msi</option>
                    <option value="Noctua">Noctua</option>
                    <option value="Thermaltake">Thermaltake</option>
                    <option value="ekwb">ekwb</option>
                    <option value="Raijintek">Raijintek</option>
                    <option value="Aerocool">Aerocool</option>
                    <option value="Antec">Antec</option>
                    <option value="Artic">Artic</option>
                    <option value="Cryorig">Cryorig</option>
                    <option value="Deepcool">Deepcool</option>
                    <option value="Enermax">Enermax</option>
                    <option value="FSP">FSP</option>
                    <option value="Phanteks">Phanteks</option>
                    <option value="Xigmatek">Xigmatek</option>
                    <option value="Mars Gaming">Mars Gaming</option>
                    <option value="Barrow">Barrow</option>
                    <option value="PNY">PNY</option>
                    <option value="Maison">Maison</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="cpu">Processeur (CPU)</label>
                <select id="cpu" name="cpu" class="form-control">
                    <option selected value="<?=$hardware->cpu;?>"><?=$hardware->cpu;?></option>
                    <option value="AMD Athlon">AMD Athlon</option>
                    <option value="AMD FX">AMD FX</option>
                    <option value="AMD Phenom">AMD Phenom</option>
                    <option value="AMD Ryzen 3">AMD Ryzen 3</option>
                    <option value="AMD Ryzen 5">AMD Ryzen 5</option>
                    <option value="AMD Ryzen 7">AMD Ryzen 7</option>
                    <option value="AMD Ryzen 9">AMD Ryzen 9</option>
                    <option value="AMD Threadripper">AMD Threadripper</option>
                    <option value="Intel Celeron">Intel Celeron</option>
                    <option value="Intel quad-core">Intel quad-core</option>
                    <option value="Intel Core I3">Intel Core I3</option>
                    <option value="Intel Core I5">Intel Core I5</option>
                    <option value="Intel Core I7">Intel Core I7</option>
                    <option value="Intel Core I9">Intel Core I9</option>
                    <option value="Intel Core Ultra">Intel Core Ultra</option>
                    <option value="Intel Pentium">Intel Pentium</option>
                    <option value="Intel Xeon">Intel Xeon</option>
                    <option value="Intel Core Processor (Haswell, no TSX)">Intel Core Processor (Haswell, no TSX)</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="motherboard">Carte mère</label>
                <select selected id="motherboard" name="motherboard" class="form-control">
                    <option value="<?=$hardware->motherboard;?>"><?=$hardware->motherboard;?></option>
                    <option value="Aorus" selected="">Aorus</option>
                    <option value="Asrock">Asrock</option>
                    <option value="Asus">Asus</option>
                    <option value="EVGA">EVGA</option>
                    <option value="Gigabyte">Gigabyte</option>
                    <option value="Intel">Intel</option>
                    <option value="MSI">MSI</option>
                    <option value="NZXT">NZXT</option>
                    <option value="Vbestlife">Vbestlife</option>
                    <option value="Biostar">Biostar</option>
                    <option value="Supermicro">Supermicro</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="memory">Mémoire RAM</label>
                <select id="memory" name="ram" class="form-control">
                    <option selected value="<?=$hardware->ram;?>"><?=$hardware->ram;?></option>
                    <option value="Adata">Adata</option>
                    <option value="Aorus">Aorus</option>
                    <option value="Apple">Apple</option>
                    <option value="Ballistix">Ballistix</option>
                    <option value="Corsair">Corsair</option>
                    <option value="Crucial">Crucial</option>
                    <option value="G.Skill">G.Skill</option>
                    <option value="Gigabyte">Gigabyte</option>
                    <option value="Integral">Integral</option>
                    <option value="Kingston">Kingston</option>
                    <option value="Patriot">Patriot</option>
                    <option value="PNY">PNY</option>
                    <option value="T-Force / Team Group">T-Force / Team Group</option>
                    <option value="Transcend">Transcend</option>
                    <option value="sodim Samsung">sodim Samsung</option>
                    <option value="Patriot Viper Steel">Patriot Viper Steel</option>
                    <option value="Micron">Micron</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="graphics_card">Carte graphique (GPU)</label>
                <select id="graphics_card" name="graphics_card" class="form-control">
                    <option selected value="<?=$hardware->graphics_card;?>"><?=$hardware->graphics_card;?></option>
                    <option value="Aorus">Aorus</option>
                    <option value="Asrock">Asrock</option>
                    <option value="Asus">Asus</option>
                    <option value="Evga">Evga</option>
                    <option value="Gainward">Gainward</option>
                    <option value="Gigabyte">Gigabyte</option>
                    <option value="Inno3D">Inno3D</option>
                    <option value="Intel">Intel</option>
                    <option value="Kfa²">Kfa²</option>
                    <option value="MSI">MSI</option>
                    <option value="Nvidia">Nvidia</option>
                    <option value="Palit">Palit</option>
                    <option value="PNY">PNY</option>
                    <option value="Sapphire">Sapphire</option>
                    <option value="Zotac">Zotac</option>
                    <option value="MTT">MTT</option>
                    <option value="Radeon">Radeon</option>
                    <option value="No Name">No Name</option>
                    <option value="IGPU">IGPU</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="ssd_m2">Stockage</label>
                <select id="ssd_m2" name="ssd_m2" class="form-control">
                    <option selected value="<?=$hardware->ssd_m2;?>"><?=$hardware->ssd_m2;?></option>
                    <option value="SSD">SSD</option>
                    <option value="HDD">HDD</option>
                    <option value="M2">M2</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="psu">Alimentation (PSU)</label>
                <select id="psu" name="psu" class="form-control">
                    <option selected value="<?=$hardware->psu;?>"><?=$hardware->psu;?></option>
                    <option value="be quiet">be quiet</option>
                    <option value="Fox Spirit">Fox Spirit</option>
                    <option value="Textorm">Textorm</option>
                    <option value="Aerocool">Aerocool</option>
                    <option value="Antec">Antec</option>
                    <option value="Asus">ASUS</option>
                    <option value="Chieftec Polaris">Chieftec Polaris</option>
                    <option value="Cooler Master">Cooler Master</option>
                    <option value="Corsair">Corsair</option>
                    <option value="Enermax MARBLEBRON">Enermax MARBLEBRON</option>
                    <option value="Enermax Revolution">Enermax Revolution</option>
                    <option value="FSP ATX">FSP ATX</option>
                    <option value="Gigabyte">Gigabyte</option>
                    <option value="Lenovo">Lenovo</option>
                    <option value="MSI">MSI</option>
                    <option value="Seasonic">Seasonic</option>
                    <option value="Tecnoware">Tecnoware</option>
                    <option value="Tacens">Tacens</option>
                    <option value="Mars Gaming">Mars Gaming</option>
                    <option value="Xilence">Xilence</option>
                    <option value="NZXT">NZXT</option>
                    <option value="Zasilacz">Zasilacz</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="screen">Marque de l'écran</label>
                <select id="screen" name="screen" class="form-control">
                    <option selected value="<?=$hardware->screen;?>"><?=$hardware->screen;?></option>
                    <option value="ASUS">ASUS</option>
                    <option value="Alienware">Alienware</option>
                    <option value="KOORUI">KOORUI</option>
                    <option value="Samsung">Samsung</option>
                    <option value="Minifire">Minifire</option>
                    <option value="Gawfolk">Gawfolk</option>
                    <option value="Dell">Dell</option>
                    <option value="IIYAMA">IIYAMA</option>
                    <option value="MSI">MSI</option>
                    <option value="Acer">Acer</option>
                    <option value="HP">HP</option>
                    <option value="CUIUIC">CUIUIC</option>
                    <option value="CHIQ">CHIQ</option>
                    <option value="BenQ">BenQ</option>
                    <option value="AOC">AOC</option>
                    <option value="Xiaomi">Xiaomi</option>
                    <option value="LG">LG</option>
                    <option value="Z-Edge">Z-Edge</option>
                    <option value="Philips">Philips</option>
                    <option value="KEFEYA">KEFEYA</option>
                    <option value="KTC">KTC</option>
                    <option value="iiyama">iiyama</option>
                    <option value="Newwin">Newwin</option>
                    <option value="Teamgee">Teamgee</option>
                    <option value="ARZOPA">ARZOPA</option>
                    <option value="VIEWSONIC">VIEWSONIC</option>
                    <option value="Gigabyte">Gigabyte</option>
                    <option value="HMTECH">HMTECH</option>
                    <option value="TuTu">TuTu</option>
                    <option value="Kenowa">Kenowa</option>
                    <option value="Thinlerain">Thinlerain</option>
                    <option value="Prechen">Prechen</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <input class="btn belcms_bg_grey" type="submit" value="Sauvegarder">
            </div>
        </div>
        <div class="section_user_computer">
            <div class="section_user_computer_row">
                <label for="os">Système d'exploitation</label>
                <select id="os" name="OS">
                    <option selected value="<?=$hardware->OS;?>"><?=$hardware->OS;?></option>
                    <option value="Windows XP">Windows XP</option>
                    <option value="Windows 7">Windows 7</option>
                    <option value="Windows 8">Windows 8</option>
                    <option value="Windows 10">Windows 10</option>
                    <option value="Windows 11">Windows 11</option>
                    <option value="MAC OS X">MAC OS X</option>
                    <option value="Android">Android</option>
                    <option value="Arch Linux">Arch Linux</option>
                    <option value="CentOS">CentOS</option>
                    <option value="Debian">Debian</option>
                    <option value="Elementary OS">Elementary OS</option>
                    <option value="Fedora Linux">Fedora Linux</option>
                    <option value="Gentoo Linux">Gentoo Linux</option>
                    <option value="Kali Linux">Kali Linux</option>
                    <option value="Linux Lite">Linux Lite</option>
                    <option value="Linux Mint">Linux Mint</option>
                    <option value="Manjaro Linux">Manjaro Linux</option>
                    <option value="Ubuntu">Ubuntu</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label>Modèle de boîtier</label>
                <input name="model_motherboard" type="text" value="<?=$hardware->model_motherboard;?>">
            </div>
            <div class="section_user_computer_row">
                <label for="mouse">Sélectionné votre souris</label>
                <select id="mouse" name="mouse">
                    <option selected value="<?=$hardware->mouse;?>"><?=$hardware->mouse;?></option>
                    <option value="Logitech G">Logitech G</option>
                    <option value="Logitech">Logitech</option>
                    <option value="Razer">Razer</option>
                    <option value="THE G-LAB">THE G-LAB</option>
                    <option value="Dierya">Dierya</option>
                    <option value="INPHIC">INPHIC</option>
                    <option value="SteelSeries">SteelSeries</option>
                    <option value="Mars Gaming">Mars Gaming</option>
                    <option value="Vinmooog">Vinmooog</option>
                    <option value="UGREEN">UGREEN</option>
                    <option value="ATTACK SHARK">ATTACK SHARK</option>
                    <option value="MSI">MSI</option>
                    <option value="HP">HP</option>
                    <option value="Trust Gaming">Trust Gaming</option>
                    <option value="Corsair">Corsair</option>
                    <option value="TMKB Technology Mechanical KeyBoard">TMKB Technology Mechanical KeyBoard</option>
                    <option value="EMPIRE GAMING">EMPIRE GAMING</option>
                    <option value="zelotes">zelotes</option>
                    <option value="APM">APM</option>
                    <option value="LexonElec">LexonElec</option>
                    <option value="VGN GAMEPOWER">VGN GAMEPOWER</option>
                    <option value="Spirit Of Gamer">Spirit Of Gamer</option>
                    <option value="Ewent">Ewent</option>
                    <option value="Zienstar">Zienstar</option>
                    <option value="AJAZZ">AJAZZ</option>
                    <option value="Tonysa">Tonysa</option>
                    <option value="Logilink">Logilink</option>
                    <option value="TECURS">TECURS</option>
                    <option value="SATECHI">SATECHI</option>
                    <option value="KLIM">KLIM</option>
                    <option value="Speedlink">Speedlink</option>
                    <option value="Gugxiom">Gugxiom</option>
                    <option value="Hama">Hama</option>
                    <option value="Amazon Basics">Amazon Basics</option>
                    <option value="Dpofirs">Dpofirs</option>
                    <option value="Lenovo">Lenovo</option>
                    <option value="Estink">Estink</option>
                    <option value="Perixx">Perixx</option>
                    <option value="Rapoo">Rapoo</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="model_cooling">Modèle de refroidissement</label>
                <input id="model_cooling" type="text" name="model_cooling" value="<?=$hardware->model_cooling;?>">
            </div>
            <div class="section_user_computer_row">
                <label for="model_cpu">Modèle processeur</label>
                <input id="model_cpu" type="text" name="model_cpu" value="<?=$hardware->model_cpu;?>">
            </div>
            <div class="section_user_computer_row">
                <label for="model_motherboard">Modèle carte mère</label>
                <input id="model_motherboard" type="text" name="model_motherboard" value="<?=$hardware->model_motherboard;?>">
            </div>
            <div class="section_user_computer_row">
                <label for="qty_ram">Quantité RAM</label>
                <select id="qty_ram" name="qty_ram" class="form-control">
                    <option selected value="<?=$hardware->qty_ram;?>"><?=$hardware->qty_ram;?></option>
                    <option value="256 Mo">256 Mo</option>
                    <option value="512 Mo">512 Mo</option>
                    <option value="1 GB">1 GB</option>
                    <option value="2 GB">2 GB</option>
                    <option value="4 GB">4 GB</option>
                    <option value="8 GB">8 GB</option>
                    <option value="16 GB">16 GB</option>
                    <option value="32 GB">32 GB</option>
                    <option value="64 GB">64 GB</option>
                    <option value="128 GB">128 GB</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="model_graphics_card">Modèle carte graphique</label>
                <input id="model_graphics_card" type="text" name="model_graphics_card" value="<?=$hardware->model_graphics_card;?>">
            </div>
            <div class="section_user_computer_row">
                <label for="size_hdd">Taille (SSD, HDD, M2)</label>
                <select name="size_hdd" class="form-control">
                    <option selected value="<?=$hardware->qty_ram;?>"><?=$hardware->qty_ram;?></option>
                    <option value="1 TO">1 TO</option>
                    <option value="2 TO">2 TO</option>
                    <option value="3 TO">3 TO</option>
                    <option value="4 TO">4 TO</option>
                    <option value="5 TO">5 TO</option>
                    <option value="6 TO">6 TO</option>
                    <option value="7 TO">7 TO</option>
                    <option value="8 TO">8 TO</option>
                    <option value="9 TO">9 TO</option>
                    <option value="10 TO">10 TO</option>
                    <option value="30 TO">30 TO</option>
                    <option value="100 TO">100 TO</option>
                    <option value="300 TO">300 TO</option>
                </select>
            </div>
            <div class="section_user_computer_row">
                <label for="watt">Détail du PSU</label>
                <input id="watt" type="text" name="watt" value="<?=$hardware->watt;?>">
            </div>
            <div class="section_user_computer_row">
                <label for="screen_resolution">Résolution</label>
                <select id="screen_resolution" name="screen_resolution" class="form-control">
                    <option selected value="<?=$hardware->screen_resolution;?>"><?=$hardware->screen_resolution;?></option>
                    <option value="352 x 240 pixels">352 x 240 pixels</option>
                    <option value="480 x 360 pixels">480 x 360 pixels</option>
                    <option value="858 x 480 pixels">858 x 480 pixels</option>
                    <option value="800 x 600 pixels">800 x 600 pixels</option>
                    <option value="1020 x 768 pixels">1020 x 768 pixels</option>
                    <option value="1280 x 800 pixels">1280 x 800 pixels</option>
                    <option value="1280 x 1024 pixels">1280 x 1024 pixels</option>
                    <option value="1600 x 1200 pixels">1600 x 1200 pixels</option>
                    <option value="1680 x 1050 pixels">1680 x 1050 pixels</option>
                    <option value="1920 x 1200 pixels">1920 x 1200 pixels</option>
                    <option value="1920 x 1080 pixels">1920 x 1080 pixels</option>
                    <option value="2560 x 1600 pixels">2560 x 1600 pixels</option>
                    <option value="2560 x 1080 pixels">2560 x 1080 pixels</option>
                    <option value="3840 x 2160 pixels">3840 x 2160 pixels</option>
                    <option value="2560 x 1440 pixels">2560 x 1440 pixels</option>
                    <option value="3840 x 2160 pixels">3840 x 2160 pixels</option>
                    <option value="5120 x 2880 pixels">5120 x 2880 pixels</option>
                    <option value="7680 x 4320 pixels">7680 x 4320 pixels</option>
                </select>
            </div>
        </div>
    </form>
</section>
<?php
endif;