<?php /* Smarty version 2.6.28, created on 2015-04-12 09:43:27
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'index.tpl', 1, false),array('function', 'html_radios', 'index.tpl', 6, false),array('function', 'html_options', 'index.tpl', 31, false),array('function', 'html_table', 'index.tpl', 66, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['header_tpl']).".tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'],'name' => ((is_array($_tmp=@$this->_tpl_vars['name']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<body>
    <form  method="post" accept-charset="utf-8">
        <div>
            <?php echo smarty_function_html_radios(array('name' => 'private','options' => $this->_tpl_vars['private_radios'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['name']['private'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => ' '), $this);?>

        </div>
        <div>
            <label><b>Ваше имя</b></label>
            <input type="text" maxlength="40" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['seller_name'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="seller_name">
        </div>
        <div>
            <label>Электронная почта</label>
            <input type="text" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['email'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="email">
        </div>
        <div>
            <label>
                <input type='hidden' value=' ' name="allow_mails">
                <input type="checkbox" value="checked" name="allow_mails" <?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['allow_mails'])) ? $this->_run_mod_handler('default', true, $_tmp, ' ') : smarty_modifier_default($_tmp, ' ')); ?>
>
                <span>Я не хочу получать вопросы по объявлению по e-mail</span>
            </label> 
        </div>
        <div>
            <label>Номер телефона</label>
            <input type="text" maxlength="11" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['phone'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="phone">
        </div>
        <div>
            <label>Город</label>
            <select name=location_id title="Выберите Ваш город">
                <option disabled="disabled">-- Города --</option>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['cities'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['name']['location_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, ''))), $this);?>

            </select>
        </div>
        <div>
            <label>Категория</label>
            <select name=category_id title="Выберите категорию объявления">
                <option value="">-- Выберите категорию --</option>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['categories'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['name']['category_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, ''))), $this);?>

            </select>
        </div>
        <div>
            <label>Название объявления</label>
            <input type="text" maxlength="50" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="title"> 
        </div>
        <div>
            <label>Описание объявления</label> 
            <textarea maxlength="3000" name="description"><?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['description'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
</textarea> 
        </div>
        <div> 
            <label>Цена</label> 
            <input type="text" maxlength="9" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['name']['price'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
" name="price">&nbsp; <span>руб.</span>
        </div>
        <div>
            <?php if (! isset ( $this->_tpl_vars['show'] )): ?>
                <input type="submit" name="button_add" value="Подать объявление" formaction="index.php">
            <?php else: ?>
                <input type="submit" name="button_add" value="Изменить объявление" formaction="index.php?id=<?php echo $this->_tpl_vars['show']; ?>
">
                <br>
                <button formaction="index.php">Отмена</button>
            <?php endif; ?>
        </div>
        <br>
    </form>

    <h2>Объявления</h2>
    <?php echo smarty_function_html_table(array('loop' => $this->_tpl_vars['list'],'cols' => "Название объявления,Цена,Имя,Удалить",'table_attr' => 'border="0" table width = 100%','th_attr' => 'bgcolor=#87CEFA','tr_attr' => $this->_tpl_vars['tr'],'td_attr' => 'align="center"'), $this);?>


    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>