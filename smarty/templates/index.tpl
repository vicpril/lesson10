{include file="$header_tpl.tpl" title=$title name=$name.title|default:''}

<body>
    <form  method="post" accept-charset="utf-8">
        <div>
            {html_radios name='private' options=$private_radios selected=$name.private|default:0 separator=' '}
        </div>
        <div>
            <label><b>Ваше имя</b></label>
            <input type="text" maxlength="40" value="{$name.seller_name|default:''}" name="seller_name">
        </div>
        <div>
            <label>Электронная почта</label>
            <input type="text" value="{$name.email|default:''}" name="email">
        </div>
        <div>
            <label>
                <input type='hidden' value=' ' name="allow_mails">
                <input type="checkbox" value="checked" name="allow_mails" {$name.allow_mails|default:' '}>
                <span>Я не хочу получать вопросы по объявлению по e-mail</span>
            </label> 
        </div>
        <div>
            <label>Номер телефона</label>
            <input type="text" maxlength="11" value="{$name.phone|default:''}" name="phone">
        </div>
        <div>
            <label>Город</label>
            <select name=location_id title="Выберите Ваш город">
                <option disabled="disabled">-- Города --</option>
                {html_options options=$cities selected=$name.location_id|default:''}
            </select>
        </div>
        <div>
            <label>Категория</label>
            <select name=category_id title="Выберите категорию объявления">
                <option value="">-- Выберите категорию --</option>
                {html_options  options=$categories selected=$name.category_id|default:''}
            </select>
        </div>
        <div>
            <label>Название объявления</label>
            <input type="text" maxlength="50" value="{$name.title|default:''}" name="title"> 
        </div>
        <div>
            <label>Описание объявления</label> 
            <textarea maxlength="3000" name="description">{$name.description|default:''}</textarea> 
        </div>
        <div> 
            <label>Цена</label> 
            <input type="text" maxlength="9" value="{$name.price|default:'0'}" name="price">&nbsp; <span>руб.</span>
        </div>
        <div>
            {if !isset($show)}
                <input type="submit" name="button_add" value="Подать объявление" formaction="index.php">
            {else}
                <input type="submit" name="button_add" value="Изменить объявление" formaction="index.php?id={$show}">
                <br>
                <button formaction="index.php">Отмена</button>
            {/if}
        </div>
        <br>
    </form>

    <h2>Объявления</h2>
    {html_table loop=$list cols="Название объявления,Цена,Имя,Удалить" 
                    table_attr='border="0" table width = 100%' th_attr='bgcolor=#87CEFA'
                    tr_attr=$tr td_attr='align="center"'}

    {include file="footer.tpl"}