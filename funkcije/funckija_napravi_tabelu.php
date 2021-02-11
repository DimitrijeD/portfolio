<?php
function napravi_tabelu($osmosmerka_niz)
{
    $html = '<table>';
    foreach( $osmosmerka_niz as $kljuc => $vrednost )
    {
        $html .= '<tr>';
        foreach($vrednost as $kljuc2 => $vrednost2)
        {
            $html .= '<td>' . htmlspecialchars($vrednost2) . '</td>';
    	}
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}