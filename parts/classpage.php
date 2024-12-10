<div class="class_members">
    <div class="classTitle">
        <h2 class="classTitleName">中等<?php echo $_GET["g"]; ?>年<?php echo $_GET["c"]; ?>組</h2>
    </div>
    <div class="classWraper">
        <div class="classMenu">
        <div class="listClass__button1 classMember">
            <button type="button" class="listClassMenu__button listClassMenu__button--classMember"><i class="fa-solid fa-user-group"></i><a href="./classpage_class_member.php?g=<?php echo$_GET["g"];?>&c=<?php echo $_GET["c"];?>" class="">クラスメンバー</a></button>
        </div>
        <div class="listClass__button1">
            <button type="button" class="listClassMenu__button listClassMenu__button--wacthPicture"><i class="fa-regular fa-images"></i><a href="./classPage_class_pictures_notUpload.php?g=<?php echo$_GET["g"];?>&c=<?php echo $_GET["c"];?>" class="">クラスの写真</a></button>
        </div>
        <div class="listClass__button1">
            <button type="button" class="listClassMenu__button listClassMenu__button--learningRecords"><i class="fa-solid fa-clipboard"></i><a href="./classPage_class_study_memories_notUpload.php?g=<?php echo$_GET["g"];?>&c=<?php echo $_GET["c"];?>" class="">クラスの学習記録</a></button>
        </div>
</div>