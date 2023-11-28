<footer class="bg-footer-mobile">
    <a href="{{route('family_member.about')}}" class="item @if($currentPage == App\Constants\FamilyMemberPage::ABOUT) active @endif">
        <div class="wrap-icon"><i class="far fa-info-square"></i></div>
        <div>Giới thiệu</div>
    </a>
    <a href="{{route('family_member.genealogy')}}" class="item @if($currentPage == App\Constants\FamilyMemberPage::GENEALOGY) active @endif">
        <div class="wrap-icon"><i class="far fa-project-diagram"></i></div>
        <div>Gia phả</div>
    </a>
    <a href="{{route('family_member.events')}}" class="item @if($currentPage == App\Constants\FamilyMemberPage::EVENT) active @endif">
        <div class="wrap-icon"><i class="far fa-calendar-alt"></i></div>
        <div>Sự kiện</div>
    </a>
    <a href="{{route('family_member.profile_index')}}" class="item @if($currentPage == App\Constants\FamilyMemberPage::PROFILE) active @endif">
        <div class="wrap-icon"><i class="far fa-address-card"></i></div>
        <div>Cá nhân</div>
    </a>
</footer>