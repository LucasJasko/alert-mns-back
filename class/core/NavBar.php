<?php

namespace core;

class NavBar
{
  public static function getNavBar()
  {
    $navbar = '<nav class="navbar">
    <ul>
      <li>
        <a href="../group/">Groupes</a>
      </li>
      <li>
        <a href="../user/">Utilisateurs</a>
      </li>
      <li>
        <a href="../params/">Paramétrages</a>
      </li>
      <li>
        <a href="../stats/">Statistiques</a>
      </li>
    </ul>
  </nav>';
    return $navbar;
  }
}
