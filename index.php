<?php
# To understand recursion, see the bottom of this file
/* 
 * w - crude php video watching script, inb4 sploits 
 * (c) 2010 Applied Magic, Inc.
 * 
 * This program is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License v2 
 * (version 2) as published by the Free Software Foundation. 
 * 
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 * GNU General Public License for more details. 
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, refer to the following URL: 
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt 
 */ 
$starttime = explode(" ",microtime());
error_reporting(E_ALL);
$defaultTitle='w';
$prots = Array(
	'youtube' => Array(
		'name'	=> 'Youtube', 
		'short'	=> 'youtube',
		'aliases' => array('YouTube.com','yt'),
		'src'	=> 'http://www.youtube.com/v/VIDYA_ID?hl=en&feature=player_embedded&version=2&',
		'type'	=> 'video',
		'embed' => 'object',
		'nsfw' => false,
		'identifier' => 'ID',
		'parameters' => array(
			'video' => array(
				'autoplay' => array(
					'label' => 'Autoplay',
					'type' => 'bool',
					'name' => 'ap',
					'default' => 1,
					'appendage' => 'autoplay=1'
				),
				'repeat' => array(
					'label' => 'Loop',
					'type' => 'bool',
					'name' => 'r',
					'default' => 0,
					'appendage' => 'loop=1'
				),
				'hd' => array(
					'label' => 'HD',
					'type' => 'bool',
					'name' => 'hd',
					'default' => 0,
					'appendage' => 'hd=1'
				),
				'time' => array(
					'label' => 'Time',
					'type' => 'string',
					'name' => 't',
					'id' => 'timeInput',
					'default' => '00:00'
				),
				'rel' => array(
					'label' => 'Related',
          'desc' => 'Display related videos in embed after video is over?',
					'type' => 'bool',
					'name' => 'rel',
					'default' => 0,
					'appendage' => 'rel=1'
				)
			)
		)
	),
	'youtubeplaylist' => Array(
		'name'	=> 'Youtube Playlist', 
		'short'	=> 'youtubeplaylist', 
    'aliases' => array('ytpl'),
    'nsfw' => false,
		'src'	=> 'http://www.youtube.com/embed/videoseries?list=VIDYA_ID',
		'type'	=> 'playlist',
		'embed' => 'iframe',
		'identifier' => 'ID'
	),
	'bliptv' => Array(
		'name' => 'Blip.TV', 
		'short' => 'bliptv',
    'aliases' => array('blip'),
    'nsfw' => false,
		'src'	=> 'http://a.blip.tv/scripts/flash/showplayer.swf?showplayerpath=http://a.blip.tv/scripts/flash/showplayer.swf&amp;file=http://VIDYA_ID.blip.tv/rss/flash/&',
		'type' => 'show',
		'embed' => 'object',
		'identifier' => 'name',
		'parameters' => array(
			'video' => array(
        'autoplay' => array(
          'label' => 'Autoplay',
          'type' => 'bool',
          'name' => 'ap',
          'default' => 1,
          'appendage' => 'autostart=true'
        ),
				'pl' => array(
					'label' => 'Playlist',
					'type' => 'bool',
					'name' => 'pl',
					'default' => 0,
					'appendage' => 'showplaylist=true'
				)
			)
		)
	),
  'empflix' => Array(
    'name'  => 'EMPFlix', 
    'short' => 'empflix', 
    'aliases' => array('empfl'),
    'nsfw' => true,
    'src' => 'http://player.empflix.com/video/VIDYA_ID',
    'type'  => 'video',
    'embed' => 'iframe',
    'identifier' => 'number'
  ),
	'justintv' => Array(
		'name' => 'Justin.tv / Twitch.tv', 
		'short' => 'justintv',
    'aliases' => array('jtv'),
    'nsfw' => false,
		'src'	=> 'http://www.justin.tv/widgets/live_embed_player.swf?channel=VIDYA_ID&',
		'type' => 'channel',
		'embed' => 'object',
		'identifier' => 'name',
		'parameters' => array(
			'video' => array(
				'autoplay' => array(
					'label' => 'Autoplay',
					'type' => 'bool',
					'name' => 'ap',
					'default' => 1,
					'appendage' => 'auto_play=true'
				)
			)
		)
	),
	'livestream' => Array(
		'name' => 'Livestream', 
		'short' => 'livestream',
    'aliases' => array('ls'),
    'nsfw' => false,
		'src'	=> 'http://cdn.livestream.com/grid/LSPlayer.swf?channel=VIDYA_ID&',
		'type' => 'channel',
		'embed' => 'object',
		'identifier' => 'name',
		'parameters' => array(
			'video' => array(
				'autoplay' => array(
					'label' => 'Autoplay',
          'desc' => 'Immediately start playing?',
					'type' => 'bool',
					'name' => 'ap',
					'default' => 1,
					'appendage' => 'autoPlay=true'
				),
				'mute' => array(
					'label' => 'Mute',
          'desc' => 'Start muted?',
					'type' => 'bool',
					'name' => 'mute',
					'default' => 0,
					'appendage' => 'mute=false'
				)
			)
		)
	),
  'porncom' => Array(
    'name' => 'porn.com', 
    'short' => 'porncom',
    'aliases' => array('porn','porn.com'),
    'nsfw' => true,
    'src' => 'http://www.porn.com/videos/embed/VIDYA_ID.html',
    'type' => 'video',
    'embed' => 'iframe',
    'identifier' => 'number'
  ),
  'redtube' => Array(
    'name' => 'RedTube', 
    'short' => 'redtube',
    'nsfw' => true,
    'src' => 'http://embed.redtube.com/player/?id=VIDYA_ID&',
    'type' => 'video',
    'embed' => 'object',
    'identifier' => 'number',
    'parameters' => array(
      'video' => array(
        'autoplay' => array(
          'label' => 'Autoplay',
          'desc' => 'Immediately start playing?',
          'type' => 'bool',
          'name' => 'ap',
          'default' => 1,
          'appendage' => 'autostart=true'
        )
      )
    )
  ),
  'slutload' => Array(
    'name' => 'SlutLoad', 
    'short' => 'slutload',
    'aliases' => array('sl'),
    'nsfw' => true,
    'src' => 'http://emb.slutload.com/VIDYA_ID',
    'type' => 'video',
    'embed' => 'object',
    'identifier' => 'ID'
  ),
	'ustream' => Array(
		'name' => 'USTREAM', 
		'short' => 'ustream',
    'nsfw' => false,
		'src'	=> 'http://www.ustream.tv/embed/VIDYA_ID',
		'type' => 'channel',
		'embed' => 'iframe',
		'identifier' => 'name'
	),
  'vimeo' => Array(
    'name' => 'Vimeo', 
    'short' => 'vimeo',
    'nsfw' => false,
    'src' => 'http://player.vimeo.com/video/VIDYA_ID',
    'type' => 'video',
    'embed' => 'iframe',
    'identifier' => 'number'
  ),
	'xfire' => Array(
		'name' => 'Xfire', 
		'short' => 'xfire',
    'nsfw' => false,
    'aliases' => array('xf'),
		'type' => 'broadcast', 
		'embed' => 'object',
		'identifier' => 'username',
		'parameters' => array(
			'video' => array(
				'autoplay' => array(
					'label' => 'Autoplay',
					'type' => 'bool',
					'name' => 'ap',
					'default' => 1
				)
			)
		)
	),
  'xhamster' => Array( 
    'name'  => 'xHamster', 
    'short' => 'xhamster',
    'aliases' => array('xh'),
    'nsfw' => true, 
    'src' => 'http://xhamster.com/xembed.php?video=VIDYA_ID',
    'type'  => 'video',
    'embed' => 'iframe',
    'identifier' => 'ID'
  ),
	'xtube' => Array( 
		'name' => 'XTube', 
		'short' => 'xtube', 
    'aliases' => array('xt'),
    'nsfw' => true, 
		'type' => 'video',
		'embed' => 'object',
      'src' => 'http://cdn1.static.xtube.com/embed/scenes_player.swf?en_flash_lib_path=http://cdn1.static.xtube.com/embed/library.swf?vx=2068&video_id=VIDYA_ID&', 
      'identifier' => 'ID'
	),
	'xvideos' => Array( 
		'name' => 'XVIDEOS', 
		'short' => 'xvideos', 
    'aliases' => array('xv'),
    'nsfw' => true, 
    'src' => 'http://flashservice.xvideos.com/embedframe/VIDYA_ID',
		'type' => 'video', 
    'embed' => 'iframe',
		'identifier' => 'ID#'
	),
  'xxxbunker' => Array(
    'name' => 'xxxbunker', 
    'short' => 'xxxbunker',
    'nsfw' => true, 
    'src' => 'http://xxxbunker.com/flash/player.swf?config=http%3A%2F%2Fxxxbunker.com%2FplayerConfig.php%3Fvideoid%3DVIDYA_ID%26',
    'type' => 'video',
    'embed' => 'object',
    'identifier' => 'ID',
    'parameters' => array(
      'video' => array(
        'autoplay' => array(
          'label' => 'Autoplay',
          'desc' => 'Immediately start playing?',
          'type' => 'bool',
          'name' => 'ap',
          'default' => 1,
          'appendage' => 'autoplay%3Dtrue'
        )
      )
    )
  ),
);
 function sortByName($a, $b) {
   return strcasecmp($b['name'], $a['name']);
 }
uksort($prots, 'sortByName');
 function sortByNSFW($a, $b) {
   return (int) $a['nsfw'] + (int) $b['nsfw'];
 }
//uksort($prots, 'sortByNSFW');
//arsort($prots);
//Get the media 'protocol' from either of the GET parameters.
foreach(array('protocol','prot','p') as $protocolREQ)
{
	if(isset($_REQUEST[$protocolREQ]))
	{
		$protocol = $_REQUEST[$protocolREQ];
		break;
	}
}

//Get the media id from either of the GET parameters.
foreach(array('id','i','v') as $idREQ)
{
	if(isset($_REQUEST[$idREQ]))
	{
		$id = $_REQUEST[$idREQ];
		break;
	}
}

class page {
	public function resolveProtocol($protocolIn)
	{
	  global $prots;
    $protocol = '';
	  foreach($prots as $proto){
      $protoNames = isset($proto['aliases']) ? $proto['aliases'] : array();
      $protoNames[] = $proto['short'];
      foreach( $protoNames as $value ) { 
        if( strtolower( $value ) == strtolower( $protocolIn ) ) { 
          $protocol = $proto['short'];
        } 
      }    
	  }
		return $protocol;
	}
	
	private function parseURL($protocol,$videoId)
	{
		global $prots;
		foreach($prots as $prot)
		{
			if($prot['short'] == $protocol)
			{
				if(isset($prot['src']) && $prot['src'] !== FALSE){
					$src = str_replace("VIDYA_ID",$videoId,$prot['src']);
					$src .= $this->parseAppends($protocol);
					return $src;
				}else{
					throw new Exception("Protocol {$prot['name']} has no set media source(src)");
				}
			}
		}
	}
	
	private function parseAppends($protocol)
	{
		global $prots;
		$append = array();
		if(isset($prots[$protocol]['parameters'])) foreach($prots[$protocol]['parameters'] as $paramsets)
		{
			foreach($paramsets as $param)
			{
				if(isset($_REQUEST[$param['name']]) && $_REQUEST[$param['name']] != false && isset($param['appendage']))
				{
					$append[] = $param['appendage'];
				}
			}
		}
		//Youtoob start-time
		if(isset($_REQUEST['t']))
		{
			preg_match("/(?<min>\d+):(?<sec>\d{2})/", $_REQUEST['t'], $matches);
			$time = $matches['min']*60+$matches['sec'];
			$append[] = "start=$time";
		}
		$append = implode($append,"&");
		
		return $append;
	}
	
	private function parseSplash()
	{
		global $prots;
		$options = '';
		$protz = $prots;
		shuffle($protz);
		foreach($prots as $proto){
  		if(@$protocol == $proto['short']){
  			$checked  = "selected='selected'";
  		}else{
  			$checked  = strlen($options) == 0 ? "selected='selected'": '';
  		}
		  $protoNames = isset($proto['aliases']) ? $proto['aliases'] : array();
      $protoNames[] = $proto['short'];
      $protoShortest = "XXXXXXXXXXXXXXXX";
      foreach($protoNames as $k => $n){
        if(strlen($n)<=strlen($protoShortest)){
          $protoShortest = $n;
        }
      }
			$options .="<option value='{$protoShortest}'>{$proto['name']}</option>\n";
		}
		return<<<SOS
<form id='form' method='get'>
  <div class="row" style='min-height: 2em;'>
    <div class="twelvecol ctexalign">
      <h1 class='' id='previewTitle'></h1>
    </div>
  </div>
  <div class="row" style='max-width: 570px;margin:0 auto;'>
    <div class="sixcol pbs">
      <select id='protocolInput' name='prot' class='select'>
        $options
      </select>
    </div>
    <div class="sixcol pbs last">
      <input name='id' id='idInput' type='text'/>
    </div>
  </div>
  <div class="row" style='max-width: 570px;margin:0 auto;'>
    <div class="twelvecol ctexalign">
      <input id='formSubmit' type='submit' value='Watch' onclick='return idInputCheck();'/>
      <div id='optionLabels'></div>
    </div>
  </div>
</form>
SOS;
	}

	public function parseTitle($protocol,$videoId)
	{
		global $prots, $defaultTitle;
		switch($protocol)
		{
			case "":
				$title = $defaultTitle;
			break; 
			case "youtube":
				$title = "durr";
				$title = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos/' . $videoId)->children('http://search.yahoo.com/mrss/')->group->title;
				$title = "$title @ Youtube($videoId)";
			break;
			case "bliptv":
				$entry = simplexml_load_file('http://blip.tv/'.$videoId.'/posts?skin=rss');
        $title = $entry->channel->title;
			break;
			default:
				$title = ucfirst($prots[$protocol]['type'])." ".$videoId.", ".$prots[$protocol]['name']." @ ".$defaultTitle;
			break;
		}
		return $title;
	}

	protected function parseOptions()
	{
		global $prots;
		$options = '';
		foreach($prots as $proto)
		{
			$options .= 'var '.$proto['short'].'Specials="';
			$arbitrarilyLongIncrementingIntegerForPickingPageOrVideoLabel = 0;
			$videoPage = array('Video','Page');
			if(isset($proto['parameters']))foreach($proto['parameters'] as $params)
			{
				foreach($params as $param)
				{
					$label	= $param['label'];
					$name	= $param['name'];
					$id		= isset($param['id'])?"id='".$param['id']."' ":"";
					$type	= str_replace(array('bool','string'), array('checkbox','text'), $param['type']);
					if(isset($param['default']))
					{
						if($type == 'checkbox'){
							$selected = $param['default'] == true ? 'checked=\'checked\' ' : '';
						}else{
							$value = "value='".$param['default']."'";
						}
					}
          			$title = isset($param['desc']) ? " title='{$param['desc']}'" : "";
					if($type==='checkbox'){$value = "value='1'";}
					$options .= "<label class='pat mrs mvt malign inline'$title>$label<input type='$type' name='$name' class='rfloat ptt prt malign' $value $id $selected/></label>";
				}
				$options .= ($arbitrarilyLongIncrementingIntegerForPickingPageOrVideoLabel==0 && isset($proto['parameters']['page'])) ? '<hr/>' : '';
				$arbitrarilyLongIncrementingIntegerForPickingPageOrVideoLabel++;
			}
			$options.="\";\n";
		}
		return $options;
	}
	
	private function parseCases()
	{
		global $prots;
		$cases = '';
		foreach($prots as $proto)
		{
      $protoNames = isset($proto['aliases']) ? $proto['aliases'] : array();
      $protoNames[] = $proto['short'];
      $protoShortest = "XXXXXXXXXXXXXXXX";
      foreach($protoNames as $k => $n){
        if(strlen($n)<=strlen($protoShortest)){
          $protoShortest = $n;
        }
      }
			$labelText = ucfirst($proto['type'])." ".$proto['identifier'];
			$cases .= <<<LOL
		case '{$protoShortest}':
			labelText = '$labelText';
			s.html({$proto['short']}Specials+standards);
		break;\n
LOL;
		}		
		return $cases;
	}
	
	private function parseHead($protocol,$videoId)
	{
		global $prots;
		$title = $this->parseTitle($protocol,$videoId);
		$options = $this->parseOptions();
		$cases = $this->parseCases();
		$html = <<<HEREDOC
		<title>$title</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	    <link rel="shortcut icon" href="http://static.derp.dk/favicon.ico" />
    <link rel="stylesheet" href="//static.derp.dk/css/1140.css" type="text/css" media="screen" /> 
		<link href="/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/swanky-purse/jquery-ui.css" rel="stylesheet" type="text/css" media="all" />
		
	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//static.derp.dk/js/css3-mediaqueries.js"></script>
    <script type="text/javascript" src="http://www.adobe.com/include/script/swfobject.js"></script>
    	<script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-9230157-2']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
		<script type="text/javascript">
		  (function( $ ) {
    $.widget( "ui.combobox", {
      _create: function() {
        var input,
          that = this,
          select = this.element.hide(),
          selected = select.children( ":selected" ),
          value = selected.val() ? selected.text() : "",
          wrapper = this.wrapper = $( "<span>" )
            .addClass( "ui-combobox" )
            .insertAfter( select );
 
        function removeIfInvalid(element) {
          var value = $( element ).val(),
            matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
            valid = false;
          select.children( "option" ).each(function() {
            if ( $( this ).text().match( matcher ) ) {
              this.selected = valid = true;
              return false;
            }
          });
          if ( !valid ) {
            // remove invalid value, as it didn't match anything
            $( element )
              .val( "" )
              .attr( "title", value + " didn't match any item" )
              .tooltip( "open" );
            select.val( "" );
            setTimeout(function() {
              input.tooltip( "close" ).attr( "title", "" );
            }, 2500 );
            input.data( "autocomplete" ).term = "";
            return false;
          }
        }
 
        input = $( "<input>" )
          .appendTo( wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "ui-state-default ui-combobox-input" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: function( request, response ) {
              var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
              response( select.children( "option" ).map(function() {
                var text = $( this ).text();
                if ( this.value && ( !request.term || matcher.test(text) ) )
                  return {
                    label: text.replace(
                      new RegExp(
                        "(?![^&;]+;)(?!<[^<>]*)(" +
                        $.ui.autocomplete.escapeRegex(request.term) +
                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
                      ), "<strong>$1</strong>" ),
                    value: text,
                    option: this
                  };
              }) );
            },
            select: function( event, ui ) {
              ui.item.option.selected = true;
              that._trigger( "selected", event, {
                item: ui.item.option
              });
            },
            change: function( event, ui ) {
              if ( !ui.item )
                return removeIfInvalid( this );
            }
          })
          .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
        input.data( "autocomplete" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + item.label + "</a>" )
            .appendTo( ul );
        };
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "ui-corner-right ui-combobox-toggle" )
          .click(function() {
            // close if already visible
            if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
              input.autocomplete( "close" );
              removeIfInvalid( input );
              return;
            }
 
            // work around a bug (likely same cause as #5265)
            $( this ).blur();
 
            // pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
            input.focus();
          });
 
          input
            .tooltip({
              position: {
                of: this.button
              },
              tooltipClass: "ui-state-highlight"
            });
      },
 
      destroy: function() {
        this.wrapper.remove();
        this.element.show();
        $.Widget.prototype.destroy.call( this );
      }
    });
  })( jQuery );
    
var standards = '';
$options
$(document).ready(function()
{
  $('#protocolInput').combobox({
         selected: function(event, ui) {
           protocolInputChange();
         } // selected
      }).addClass('fat');
  $('#idInput').autocomplete({source:['1337']});
  $('#idInput').addClass('ui-widget');
  $('#idInput').addClass('fat');
  $('#idInput').addClass('ui-state-default');
  $('#idInput').css('color','white');
  $('#formSubmit').button();
	function protocolInputChange(){
		var s = $('#optionLabels');
		var labeltext;
    switch ($('select[name=prot] option:selected').val())
		{
	$cases	}
    $("#idInput").attr('placeholder',labelText);
	}
	protocolInputChange();
	$('#protocolInput').bind('change', protocolInputChange);
	
	$('#idInput').bind('change keyup click select blur', function hurr() {
	  previewLoad();
	});
  function previewLoad() {
  	/*
    $.get("index.php",{ prot: $('input:radio[name=prot]:checked').val(), id: $('#idInput').val(), async: 'title' }, function(data) {
      $('#previewTitle').html(data);
    });
    */
    }
		
	$('#form').submit(function() {
      var stupidAutoplay = '';
      if($('input:checkbox[name=ap]:checked').val()=='1'){
      	$('input:checkbox[name=ap]:checked').removeAttr('name');
      } else {
//      	stupidAutoplay = 'ap=0&';
      }
      if($('input:text[name=time]').val()=='00:00'){
      	$('input:text[name=time]').removeAttr('name');
      }
      var prot = $('select[name=prot] option:selected').val();
      $('#protocolInput').removeAttr('name');
      $('#idInput').removeAttr('name');
      var dontquestionmyauthority = $(form).serialize() != '' ? '?':'';
      window.location = (prot+'/'+$("#idInput").val()+dontquestionmyauthority+stupidAutoplay+$("form").serialize().substr($("form").serialize().indexOf('&')+1).substr($("form").serialize().substr($("form").serialize().indexOf('&')+1).indexOf('&')+1));
	  return false;
	});
	$('#timeInput').bind('blur', function timeInputClear() {
    if($('#timeInput').val() === ''){
      $('#timeInput').attr('value','00:00');
      $("#timeInput").css('color','black');
    }
	});
	 
	$('#timeInput').bind('focus', function timeInputFill() {
    if($("#timeInput").val() === '00:00'){
      $("#timeInput").attr('value','');
      $("#timeInput").css('color','#9d9d9d');
    }
	});
});
		</script>
HEREDOC;
		return $html;
	}
	
	public function parsePlayer($protocol,$videoId){
		global $prots;
		if($videoId == ''){
			$html = $this->parseSplash();
		}else if($prots[$protocol]['embed']=='object'){
			$src = $this->parseURL($protocol,$videoId);
			$html = <<<HEREDOC
		<object>
			<param name="movie" value="$src"></param>
			<param name="allowFullScreen" value="true" /> 
			<param name="allowScriptAccess" value="always" /> 
			<param name="allowNetworking" value="all" /> 
			<embed src="$src" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
		</object>
HEREDOC;
		}else if($prots[$protocol]['embed']=='iframe'){
			$src = $this->parseURL($protocol,$videoId);
			$html = <<<HEREDOC
		<iframe src="$src" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
HEREDOC;
		}
		return $html;
	}
	
	public function printPage($protocol='', $videoId='')
	{
		$protocol = $this->resolveProtocol($protocol);
		if($protocol == "ustream") $videoId = simplexml_load_file("http://api.ustream.tv/xml/channel/$videoId/getValueOf/id")->results;
		$head = $this->parseHead($protocol, $videoId);
		$body = $this->parsePlayer($protocol, $videoId);
		$html = <<<SOS
<!DOCTYPE html>
<html>
	<head>
$head
	</head>
	<body>
$body
	</body>
</html>
SOS;
	print $html;
	}
}

class async extends page {
	public function __construct($protocol,$videoId,$query)
	{
	  global $defaultTitle;
		$protocol = $this->resolveProtocol($protocol);
		if($protocol == "ustream") $videoId = simplexml_load_file("http://api.ustream.tv/xml/channel/$videoId/getValueOf/id")->results;
		switch($protocol)
		{
			case "":
				$title = $defaultTitle;
			break; 
			case "youtube":
				$this->xml = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos/' . $videoId);
			break;
			case "bliptv":
				$this->xml = simplexml_load_file('http://blip.tv/posts/?skin=rss&user=' . $videoId);
			break;
			case "ustream":
				$this->xml = simplexml_load_file("http://api.ustream.tv/xml/channel/$videoId/getInfo")->results;
			break;
			default:
			break;
		}
		switch($query){
			case 'title':
				echo $this->parseTitle($protocol,$videoId);
			break;
			case 'thumb':
				echo $this->parseThumb($protocol,$videoId);
			break;
			case 'player':
				echo $this->parsePlayer($protocol,$videoId);
			break;
		}
	}
	public function parseTitle($protocol,$videoId)
	{
		global $prots, $defaultTitle;
		switch($protocol)
		{
			case "":
				$title = $defaultTitle;
			break; 
			case "youtube":
				$title = $this->xml->children('http://search.yahoo.com/mrss/')->group->title;
			break;
			case "bliptv":
				$title = $this->xml->channel->title;
			break;
			case "ustream":
				$title = $this->xml->title;
			break;
			default:
				$title = $videoId." @ ".$prots[$protocol]['name'];
			break;
		}
//		$title = trim($title);
		return trim($title);
	}
	public function parseThumb($protocol,$videoId){
		switch($protocol){
		case "youtube":
			$media = $this->xml->children('http://search.yahoo.com/mrss/');
			$attr = $media->group->thumbnail[0]->attributes();
			$src = $attr['url'];
			break;
		case "bliptv":
			$src = $this->xml->channel->item[0]->children('blip',true)->picture;
			break;
		case "ustream":
			$src = $this->xml->imageUrl->small;
			break;
		default:
			return "";
		}
		if($src)return "<img src='$src' class='thumb'/>"; 
	}
}

if(isset($_REQUEST['async']) && !empty($protocol) && !empty($id))
{
	ini_set("display_errors", 0); 
	try {
		new async($protocol, $id, $_REQUEST['async']);
	} catch (Exception $e) {
        echo "<!--- \nCaught exception: {$e->getMessage()}\n{$e}\n --->";
  }
}else{
	try {
		$page = new page();
		if(isset($protocol) && isset($id))
		{
			$page->printPage($protocol, $id);
		}else{
			$page->printPage();
		}
	} catch (Exception $e) {
		$page->printPage();
        echo "<pre style='position:absolute;top:0;'>\nCaught exception: ('{$e->getMessage()}')\n{$e}\n</pre>";
    }
	$endtime = explode(" ",microtime()); 
	$totaltime = (($endtime[1] + $endtime[0]) - ($starttime[1]+$starttime[0]));
    echo "\n<!-- This page(".__FILE__.") was created in ".$totaltime." seconds on ".PHP_OS." running PHP ".PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION.".".PHP_RELEASE_VERSION." -->";
}
# To understand recursion, see the top of this file
?>