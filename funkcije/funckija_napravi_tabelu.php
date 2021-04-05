<?php
function napravi_tabelu($osmosmerka_niz)
{
    $html = '<table>';
    foreach( $osmosmerka_niz as $kljuc => $vrednost )
    {

        $html .= '<tr>';
        foreach($vrednost as $kljuc2 => $vrednost2)
        {
            // var_dump($kljuc2);
            $html .= '<td>' . htmlspecialchars($vrednost2) . '</td>';
    	}
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}

function napravi_osmosmerku_v1($osmosmerka_niz, $prikazi_puteve = null, $asim_polja = null)
{
    $polje_je_asm = array('a');
    // pravi se asimetricna
    // $sakrij = 'class="saktrij_polje';
    

    if($prikazi_puteve){
        $onmouseover_events = 'onmouseover="Highlight_obj.prikazi_sve_puteve(this.id)" onmouseout="Highlight_obj.vrati_normalno_stanje(this.id)" ';
    } else {
        $onmouseover_events = ' ';
    }

    $mouse_click_event = 'onclick="kliknuto_polje(this.id)"';
    $html = '<table style="cursor: pointer;">';

    foreach( $osmosmerka_niz as $kljuc_reda => $red )
    {
        $html .= '<tr>';
        foreach($red as $kolona => $slovo)
        {
            // var_dump($asim_polja);
            if($asim_polja != null)
            {
                $polje = array(array($kljuc_reda, $kolona)); // jer funkcija ocekuje niz nizova
                // var_dump($polje);
                $polje_je_asm = asm_uklanjanje_polja_iz_preostalih_polja($polje, $asim_polja);
                // var_dump($polje_je_asm);
            }
            if(empty($polje_je_asm))
            { //id="nope"
                $html .= '<td class="noselect" id="none" style="background-color:#eff5f5; border: 2px solid #eff5f5;">' . htmlspecialchars($slovo) . '</td>'; 
            } else {
                $id = $kljuc_reda . "/" . $kolona;
                $html .= '<td class="noselect" id="' . $id . '"' . $onmouseover_events . " " . $mouse_click_event . '>' . htmlspecialchars($slovo) . '</td>'; 
            }
            
        }
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}