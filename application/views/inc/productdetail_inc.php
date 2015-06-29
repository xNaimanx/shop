<div id="content" class="float_r">
<?php
echo <<<HTML
    <h3 style="text-align:center; line-height:1.2">{$arr['author']}-{$arr['title']}</h3>
    <div class="cleaner h10"></div>
    <div class="content_half float_l">
  <a href={$arr['image_large']} class="zoom"><img src={$arr['image_medium']} alt={$arr['title']} /></a>
    </div>
    <div class="content_half float_r">
<table>
            <tr>
                <td height="30" width="160">Название:</td>
                <td>{$arr['title']}</td>
            </tr>
            <tr>
                <td height="30">Автор:</td>
                <td>{$arr['author']}</td>
            </tr>
            <tr>
                <td height="30">Год издания:</td>
                <td>{$arr['pubyear']}</td>
            </tr>
            <tr>
                <td height="30">Категория:</td>
                <td>{$arr['category']}</td>
            </tr>
            <tr>
                <td height="30">Жанр:</td>
                <td>{$arr['genre']}</td>
            </tr>
            <tr>
                <td height="30">Цена:</td>
                <td>{$arr['product_price']}</td>
            </tr>

        </table>
        <div class="cleaner h20"></div>
        <a href="/shoppingcart?id=$id" class="add_to_card">Добавить в корзину</a>
        <div class="cleaner h10"></div>
        <a href="javascript:history.back()">Продолжить покупки</a></p>
</div>
    <div class="cleaner h30"></div>

    <h5>Описание книги</h5>
    <p>{$arr['product_description']}</p>
HTML;
?>
    <div class="cleaner h50"></div>



</div>
