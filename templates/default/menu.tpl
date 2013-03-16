{* Titre du bloc *}
<h1 class="nojs">{_T string="CSV Exports"}</h1>
{* Entrées du menu *}
<ul>
{if $login->isAdmin()}
   {* Une entrée de menu visible uniquement par les administrateurs *}
   <li><a href="{$galette_base_path}{$galette_csv_export_path}export_contrib.php">{_T string="Export contributions"}</a></li>
{/if}
</ul>
