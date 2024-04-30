<?php
global $login_user;
$get_grade_sql = "select * from grade";
$grades = get_query($get_grade_sql,null,true);
$get_class_sql = "select * from class";
$classes = get_query($get_class_sql,null,true);
?>
<div class="mainMenu">
            <h2 class="listMenu__title1">桐蔭学園中等教育学校</h2>
            <p class="listMenu__title3"><?php echo $login_user["name"]; ?><br><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</p>
            <div class="listMenu__item">
                <form action="classpage_class_member.php" method="get">
                    <h2 class="listMenu__title2">学年</h2>
                    <select name="g" class="listMenu__classSelect">
                        <option disabled selected value>学年を選択</option>
                        <?php foreach($grades as $grade): ?>
                            <option class="option" value="<?php echo $grade["id"] ?>"><?php echo $grade["grade_number"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <h2 class="listMenu__title2">クラス</h2>
                    <select name="c" class="listMenu__classSelect">
                        <option disabled selected value>クラスを選択</option>
                        <?php foreach($classes as $class): ?>
                            <option class="" value="<?php echo $class["id"] ?>"><?php echo $class["class_number"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="listMenu__buttonLayout">
                        <button type="submit" class="listMenu__button"><i class="fa-solid fa-magnifying-glass"></i>探す</button>
                    </div>
                </form>
                <div class="listMenu__buttonLayout2">
                    <button type="button" class="listMenu__button listMenu__button--classStudent"><i class="fas fa-user"></i><a href="./find_students.php" class="">生徒を探す</a></button>
                </div>
            </div>
            <div class="listMenu__item">
                <button type="button" class="listMenu__button listMenu__button--class"><i class="fas fa-user-pen"></i><a href="./self_introduction_edit.php" class="">クラスページを編集</a></button>
            </div>
            <div class="listMenu__buttonLayout3">
                <button type="button" class="listMenu__button listMenu__button--community"><i class="fas fa-users"></i><a href="./community.php" class="">コミュニティ</a></button>
            </div>
        </div>