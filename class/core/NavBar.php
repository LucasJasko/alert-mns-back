<?php

namespace core;

class NavBar
{
  public static function getNavBar()
  {
    $navbar = '
  <nav class="navbar">
    <div class="navbar__container">
        <div class="navbar__container__left">
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
        </div>
        <div class="navbar__container__right">
          <div class="log-out__btn">
              <i class="fa-solid fa-power-off"></i>
          </div>
        </div>
    </div>
  </nav>';
    return $navbar;
  }
}
