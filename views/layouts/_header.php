<div id="kt_app_header" class="app-header ">

  <!--begin::Header container-->
  <div class="app-container  container-fluid d-flex align-items-stretch justify-content-between "
    id="kt_app_header_container">
    <!--begin::Mobile menu toggle-->
    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
      <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
        <i class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span class="path2"></span></i>
      </div>
    </div>
    <!--end::Mobile menu toggle-->


    <!--begin::Mobile logo-->
    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
      <a href="/good/index.html" class="d-lg-none">
        <img alt="Logo" src="/media/logos/default.svg" class="h-25px">
      </a>
    </div>
    <!--end::Mobile logo-->

    <!--begin::Header wrapper-->
    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">


      <!--begin::Page title-->
      <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex flex-column justify-content-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
        </h1>
        <!--end::Title-->

      </div>
      <!--end::Page title-->
      <!--begin::Navbar-->
      <div class="app-navbar align-items-center flex-shrink-0">
        <!--begin::Search-->
        <div class="app-navbar-item ms-2 ms-lg-4">
        </div>
        <!--end::Search-->


        <!--begin::Theme mode-->
        <div class="app-navbar-item ms-2 ms-lg-4">

          <!--begin::Menu toggle-->
          <a href="#" class="btn btn-custom btn-outline btn-icon btn-icon-gray-700 btn-active-icon-primary"
            data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-night-day theme-light-show fs-1"><span class="path1"></span><span
                class="path2"></span><span class="path3"></span><span class="path4"></span><span
                class="path5"></span><span class="path6"></span><span class="path7"></span><span
                class="path8"></span><span class="path9"></span><span class="path10"></span></i> <i
              class="ki-duotone ki-moon theme-dark-show fs-1"><span class="path1"></span><span
                class="path2"></span></i></a>
          <!--begin::Menu toggle-->

          <!--begin::Menu-->
          <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
            data-kt-menu="true" data-kt-element="theme-mode-menu" style="">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
              <a href="#" class="menu-link px-3 py-2 active" data-kt-element="mode" data-kt-value="light">
                <span class="menu-icon" data-kt-element="icon">
                  <i class="ki-duotone ki-night-day fs-2"><span class="path1"></span><span class="path2"></span><span
                      class="path3"></span><span class="path4"></span><span class="path5"></span><span
                      class="path6"></span><span class="path7"></span><span class="path8"></span><span
                      class="path9"></span><span class="path10"></span></i> </span>
                <span class="menu-title">
                  Light
                </span>
              </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
              <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                <span class="menu-icon" data-kt-element="icon">
                  <i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span class="path2"></span></i> </span>
                <span class="menu-title">
                  Dark
                </span>
              </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
              <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                <span class="menu-icon" data-kt-element="icon">
                  <i class="ki-duotone ki-screen fs-2"><span class="path1"></span><span class="path2"></span><span
                      class="path3"></span><span class="path4"></span></i> </span>
                <span class="menu-title">
                  System
                </span>
              </a>
            </div>
            <!--end::Menu item-->
          </div>
          <!--end::Menu-->

        </div>
        <!--end::Theme mode-->

      </div>
      <!--end::Navbar-->
    </div>
    <!--end::Header wrapper-->
  </div>
  <!--end::Header container-->
</div>