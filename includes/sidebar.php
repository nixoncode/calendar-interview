<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="/assets/img/logo/png/logo.png" alt="Brand Logo" class="img-fluid" style="width: 90px" />
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2"></span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <?php foreach ($menuItems as $item) {
      if (in_array($userRole, $item['allowedRoles'])) { ?>
        <li class="menu-item <?= isURLActive($item) ? 'active ' : '' ?> <?= !empty($item['subItems']) && !empty(array_filter($item['subItems'], 'isURLActive')) ? 'active open' : '' ?>">
          <a href="<?= BASE_URL .  $item['url'] ?>" class="menu-link <?= !empty($item['subItems']) ? 'menu-toggle' : '' ?>">
            <i class="menu-icon tf-icons <?= $item['icon'] ?>"></i>
            <div><?= $item['title'] ?></div>
          </a>
          <?php if (!empty($item['subItems'])) { ?>
            <ul class="menu-sub">
              <?php foreach ($item['subItems'] as $subItem) {
                if (in_array($userRole, $subItem['allowedRoles'])) { ?>
                  <li class="menu-item <?= isURLActive($subItem) ? 'active' : '' ?>">
                    <a href="<?= BASE_URL .  $subItem['url'] ?>" class="menu-link">
                      <div>
                        <?= $subItem['title'] ?>
                      </div>
                    </a>
                  </li>
              <?php }
              } ?>
            </ul>
          <?php } ?>
        </li>
    <?php }
    } ?>
  </ul>
</aside>