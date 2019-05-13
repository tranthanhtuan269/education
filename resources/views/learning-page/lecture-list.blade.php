<div class="learning-lecture-list">
    <div class="learning-lecture-list-searchbar">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for lectures">
            
            <span class="input-group-addon" ><i class="fas fa-search"></i></span>
            
        </div>
        <button class="btn" id="btnCloseSidebar"><i class="fas fa-times-circle"></i></button>
        
    </div>
    
    <div class="learning-lecture-list-body">
        @for ($i = 0; $i < 5; $i++)
        <div class="ln-lect-list-item">
        <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody{{$i}}">
                <div class="ln-lect-list-header-row-1">
                    <p class="ln-lect-list-sect-number">Section 1</p>
                    <p class="ln-lect-list-sect-counter">0/18</p>
                </div>
                <div class="ln-lect-list-header-row-2">
                    <h4 class="ln-lect-list-sect-title">Thanh Tuan xau trai</h4>
                </div>
            </div>
        <div id="sectionBody{{$i}}" class="ln-lect-list-body collapse">
                <ul>
                    <li>
                        <a>
                            <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                            <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                            <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
                        </a>
                    </li>
                    <li>
                        <a>
                            <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                            <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset Ronaldo Khedira Alibaba Antonio Valencia </span>
                            <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
                        </a>
                    </li>
                    <li>
                        <a>
                            <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                            <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                            <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
            
        @endfor
    </div>
</div>