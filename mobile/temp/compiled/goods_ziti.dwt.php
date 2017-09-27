<!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title><?php echo $this->_var['page_title']; ?></title>
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/ziti.css"/> 
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js')); ?><?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?>
</head>
<body>
<header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">自提点</div>
          <div class="h-right">
            <aside class="top_bar" style="margin-right:5px;">
              <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
            </aside>
          </div>
        </div>
      </div>
      </header>
<?php echo $this->fetch('library/up_menu.lbi'); ?>   
  
 <div class="pickup_point_wrap">
<div id="area_list_wrap" >
                    <div id="area_menu"> <a id="province" href="javascript:void(0);">省</a> <a id="city" href="javascript:void(0);">市</a> <a class="hover" id="district" href="javascript:void(0);">区</a>
                      <div style="clear:both"></div>
                    </div>
                    <ul id="area_list">
                    </ul>
                  </div>
<div style="clear:both"></div>
<div id="pickup_point_list" >


</div>
</div>
<script>
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;
var suppid = <?php echo $this->_var['goods']['supplier_id']; ?>;
                </script>
<script src="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js" type="text/javascript"></script>
<script>

 $.ajax({
        url:'goods.php?act=get_pickup_info&province='+remote_ip_info.province+'&city='+remote_ip_info.city+'&district='+remote_ip_info.district+'&suppid='+suppid,
        dataType: 'json', 
        success:function(res){
		if(res.error == 0) {
		var result = '<div class="point-list" id="pointList"><h3 class="title">自提点列表</h3>';
			if(res.length > 0)
			{
				for(var i=0; i<res.length; i++)
				{
				result += '<div class="block">';				
				result += '<div class="fl"> <a href="javascript:void(0);"><ul>';	
				result += '<li class="one"><img src="themesmobile/68ecshopcom_mobile/images/ziti.png"></li>';	
				result += '<li class="two"><h3>'+res[i].shop_name+'</h3><p>'+res[i].address+
								'</p></li>';
    result += '<div class="clear"></div></ul></a></div>';
	result += '<div class="tel" ><span>联系人:'+res[i].contact+'</span><span><img src="themesmobile/68ecshopcom_mobile/images/tel.png">'+res[i].phone +'</span></div>';
	result += '</div>';	
				}
				result += '</div>';
				document.getElementById('pickup_point_list').innerHTML = result;
				
			}
			else{
				document.getElementById('pickup_point_list').innerHTML = '<div class="point-list" id="pointList"><h3 class="title">自提点列表</h3><div style="padding:10px 0;text-align:center; font-size:14px;">该地区尚未开放自提点</div></div>';
				
			}
			//hide_area();
			show_list();
			document.getElementById('province').innerHTML = res.city_info.province;
			document.getElementById('province').onclick = function(){
				get_area_list(<?php echo $this->_var['shop_country']; ?>, '');
			}
			document.getElementById('city').innerHTML = res.city_info.city;
			document.getElementById('city').onclick = function(){
				get_area_list(res.city_info.province_id, res.city_info.province);
			}
			get_area_list(res.city_info.city_id, res.city_info.city);
		}
	}
});	


function show_list()
{

	document.getElementById('pickup_point_list').style.display = "block";
}
function hide_list()
{

	document.getElementById('pickup_point_list').style.display = "none";
}
function get_area_list(parent_id, name)
{
	Ajax.call('goods.php', 'act=get_area_list&parent_id='+parent_id, function(res) {
		var result = '';
		for(var i=0; i<res.length; i++)
		{
			result += '<li';
			if(res[i].region_name.length>5)
				result += ' style="widht:170px;"';
			result += '><a href="javascript:void(0)" ';
			if(res[i].region_type == 3)
				result += 'onclick="get_pickup_point_list('+res[i].region_id+', this)">';
			else
				result += 'onclick="get_area_list('+res[i].region_id+', \''+res[i].region_name+'\')">';
			result+=res[i].region_name+'</a></li>';
		}
		result += '';
		document.getElementById('area_list').innerHTML = result;
		
		switch(res[0].region_type)
		{
			case '1':
				document.getElementById('province').onclick = function(){get_area_list(parent_id, name);};
				document.getElementById('city').innerHTML = '市';
				document.getElementById('district').innerHTML = '区';
				switch_hover('province');
				break;
			case '2':
				document.getElementById('city').onclick = function(){get_area_list(parent_id, name);};
				document.getElementById('province').innerHTML = name;
				//document.getElementById('city').innerHTML = '市';
				document.getElementById('district').innerHTML = '区';
				switch_hover('city');
				break;
			case '3':
                                document.getElementById('district').onclick = function(){get_area_list(parent_id, name);};
				document.getElementById('city').innerHTML = name;
				document.getElementById('district').innerHTML = '区';
				switch_hover('district');
				break;
		}
		hide_list();
		//show_area();
	}, 'GET', 'JSON');
}

function switch_hover(sel)
{
	if(sel == 'province')
	{
		document.getElementById('city').className = '';
		document.getElementById('district').className = '';
		document.getElementById('province').className = 'hover';
	}
	else if(sel == 'city')
	{
		document.getElementById('city').className = 'hover';
		document.getElementById('district').className = '';
		document.getElementById('province').className = '';
	}
	else
	{
		document.getElementById('city').className = '';
		document.getElementById('district').className = 'hover';
		document.getElementById('province').className = '';
	}
}

function get_pickup_point_list(region_id, obj)
{
	var name = obj.innerHTML;
	document.getElementById('district').innerHTML = name;
	var label = document.getElementById('province').innerHTML + '&nbsp;' +
				document.getElementById('city').innerHTML + '&nbsp;' +
				document.getElementById('district').innerHTML;
	
	Ajax.call('goods.php', 'act=get_pickup_point_list&district_id='+region_id+'&suppid='+suppid, function(res) {
	var result = '<div class="point-list" id="pointList"><h3 class="title">自提点列表</h3>';
			if(res.length > 0)
			{
				for(var i=0; i<res.length; i++)
				{
				result += '<div class="block">';				
				result += '<div class="fl"> <a href="javascript:void(0);"><ul>';	
				result += '<li class="one"><img src="themesmobile/68ecshopcom_mobile/images/ziti.png"></li>';	
				result += '<li class="two"><h3>'+res[i].shop_name+'</h3><p>'+res[i].address+
								'</p></li>';
    result += '<div class="clear"></div></ul></a></div>';
	result += '<div class="tel" ><span>联系人:'+res[i].contact+'</span><span><img src="themesmobile/68ecshopcom_mobile/images/tel.png">'+res[i].phone +'</span></div>';
	result += '</div>';	
				}
				result += '</div>';
				document.getElementById('pickup_point_list').innerHTML = result;
				
			}
			else{
				document.getElementById('pickup_point_list').innerHTML = '<div class="point-list" id="pointList"><h3 class="title">自提点列表</h3><div style="padding:10px 0;text-align:center; font-size:14px;">该地区尚未开放自提点</div></div>';
				
			}
			//hide_area();
			show_list();
			
			
	}, 'GET', 'JSON');
}
/*function show_area()
{
	document.getElementById('area_label').style.borderBottom = "1px #fff solid";
	document.getElementById('area_list_wrap').style.display = "block";
}
function hide_area()
{
	document.getElementById('area_label').style.borderBottom = "1px solid #ccc";
	document.getElementById('area_list_wrap').style.display = "none";
}*/
</script>
</body>
</html>