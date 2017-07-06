{include file="header.html.php"}
{if isset($login) and $access == 2}
<div class="container">
    <div class="panel-body">
        {if $allMecz|@count === 0}
        <div class="alert alert-danger" role="alert">Brak meczy w kolejce</div>
        {/if}
        {foreach $allMecz as $key}
        <div class="row">
            <div class="col-md-12">{$key['dataMeczu']} {$key['godzinaRozpoczecia']}</div>
        </div>
        <form id="addpet" action="http://{$smarty.server.HTTP_HOST}{$subdir}Mecz/insertResult/{$idKolejka}" method="post">
        <div class="row">

            <div class="col-md-2" >
                {$key['league']}
            </div>
            <div class="col-md-2" >{$key['gospodarzNazwa']}</div>
            <div class="col-md-2" >

                <label for="golGospodarz" ></label><input id="golGospodarz"  type="text" size="1"  name="{$key['idMecz']}Gospodarz" value="{$key['golGospodarz']}" style="text-align: center"/>:<label for="golGosc"></label><input id="golGosc" type="text" size="1"  name="{$key['idMecz']}Gosc" value="{$key['golGosc']}" style="text-align: center"/>

            </div>
            <div class="col-md-2" >{$key['goscNazwa']}</div>
            <div class="col-md-2" >

            </div>
            <div class="col-md-1" >

                {assign var="temp_id" value=$key['idMecz']}
                <a type="button" class="btn btn-default" href="http://{$smarty.server.HTTP_HOST}{$subdir}Mecz/update/{$temp_id}">Edytuj</a>
            </div>
            <div class="col-md-1" >

                {assign var="temp_id" value=$key['idMecz']}
                <a type="button" class="btn btn-default" href="http://{$smarty.server.HTTP_HOST}{$subdir}Mecz/delete/{$temp_id}">Usun</a>
            </div>
            
            



        </div>

        {/foreach}
            <button type="submit" class="btn btn-default">Zapisz zmiany</button>
            </form>

    </div>


</div>
{else}
{include file="logform.html.php"}
{/if}
{include file="footer.html.php"}

