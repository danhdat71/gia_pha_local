<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a
                        class="waves-effect waves-dark @if($currentPage == App\Constants\FamilyMemberPage::ABOUT) active @endif"
                        href="{{route('family_member.about')}}"
                        aria-expanded="false"
                    >
                        <i class="far fa-info-square font-color-1"></i><span class="hide-menu font-color-1">Giới thiệu</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark @if($currentPage == App\Constants\FamilyMemberPage::GENEALOGY) active @endif" href="{{route('family_member.genealogy')}}" aria-expanded="false">
                        <i class="far fa-project-diagram font-color-1"></i><span class="hide-menu font-color-1">Gia phả</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark @if($currentPage == App\Constants\FamilyMemberPage::EVENT) active @endif" href="{{route('family_member.events')}}" aria-expanded="false">
                        <i class="far fa-calendar-alt font-color-1"></i><span class="hide-menu font-color-1">Sự kiện</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark @if($currentPage == App\Constants\FamilyMemberPage::PROFILE) active @endif" href="{{route('family_member.mypage')}}" aria-expanded="false">
                        <i class="far fa-address-card font-color-1"></i><span class="hide-menu font-color-1">Cá nhân</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark @if($currentPage == App\Constants\FamilyMemberPage::FUNDS) active @endif" href="{{route('family_member.funds')}}" aria-expanded="false">
                        <i class="nav-icon fas fa-funnel-dollar font-color-1"></i><span class="hide-menu font-color-1">Quỹ thu chi</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark  @if($currentPage == App\Constants\FamilyMemberPage::FUND_REGIST) active @endif" href="{{route('family_member.fund_register_view')}}" aria-expanded="false">
                        <i class="far fa-plus-octagon font-color-1"></i><span class="hide-menu font-color-1">Đăng ký quỹ</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark @if($currentPage == App\Constants\FamilyMemberPage::CONTACT) active @endif" href="{{route('family_member.contact_info')}}" aria-expanded="false">
                        <i class="far fa-id-card font-color-1"></i><span class="hide-menu font-color-1">Liên hệ</span>
                    </a>
                </li>
            </ul>
            <div class="mt-4">
                <a href="{{route('family_member.logout')}}" class="btn waves-effect waves-light btn-danger hidden-md-down text-white btn-sm">Đăng xuất</a>
            </div>
        </nav>
    </div>
</aside>