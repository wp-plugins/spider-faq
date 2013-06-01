function reset_theme_1()
{
if(confirm('Do you really whant to reset theme?')){
document.getElementById('title').value='White';
document.getElementById('show2').checked="true";
document.getElementById('post_image1').value='';
document.getElementById('bgcolor').color.fromString('');
document.getElementById('width').value='600';
document.getElementById('ctbg1').checked="true";
document.getElementById('ctbggrad1').checked="true";
document.getElementById('ctbgcolor').color.fromString('');
document.getElementById('ctgradtype').value='top';
document.getElementById('ctgradcolor1').color.fromString('44A9CF');
document.getElementById('ctgradcolor2').color.fromString('54DDFF');
document.getElementById('cttxtcolor').color.fromString('FFFFFF');
document.getElementById('ctfontsize').value='20';
document.getElementById('ctmargin').value='0 60 0 0';
document.getElementById('ctpadding').value='9 20 12';
document.getElementById('ctbstyle').value='solid';
document.getElementById('ctbwidth').value='2';
document.getElementById('ctbcolor').color.fromString('E0E0E0');
document.getElementById('ctbradius').value='2';
document.getElementById('cdbg1').checked="true";
document.getElementById('cdbggrad0').checked="true";
document.getElementById('cdbgcolor').color.fromString('C4C4C4');
document.getElementById('cdgradtype').value='top';
document.getElementById('cdgradcolor1').color.fromString('');
document.getElementById('cdgradcolor2').color.fromString('');
document.getElementById('cdtxtcolor').color.fromString('000000');
document.getElementById('cdfontsize').value='12';
document.getElementById('cdmargin').value='10 90 12 21';
document.getElementById('cdpadding').value='4 8';
document.getElementById('cdbstyle').value='double';
document.getElementById('cdbwidth').value='3';
document.getElementById('cdbcolor').color.fromString('FFFFFF');
document.getElementById('cdbradius').value='2';
document.getElementById('paddingbq').value='';
document.getElementById('marginleft').value='6';
document.getElementById('theight').value='30';
document.getElementById('twidth').value='512';
document.getElementById('tfontsize').value='14';
document.getElementById('ttxtwidth').value='';
document.getElementById('ttxtpleft').value='6';
document.getElementById('tcolor').color.fromString('000000');
document.getElementById('titlebg0').checked="true";
document.getElementById('tbgcolor').color.fromString('FFFFFF');
document.getElementById('post_image2').value='';
document.getElementById('titlebggrad0').checked="true";
document.getElementById('gradtype').value='top';
document.getElementById('gradcolor1').color.fromString('');
document.getElementById('gradcolor2').color.fromString('');
document.getElementById('tbghovercolor').color.fromString('EDEAD8');
document.getElementById('tbgsize').value='100%';
document.getElementById('tbstyle').value='solid';
document.getElementById('tbwidth').value='1';
document.getElementById('tbcolor').color.fromString('C7C7C7');
document.getElementById('tbradius').value='4';
document.getElementById('post_image3').value='';
document.getElementById('marginlimage1').value='';
document.getElementById('post_image4').value='';
document.getElementById('marginlimage2').value='';
document.getElementById('awidth').value='513';
document.getElementById('amargin').value='0 15 25';
document.getElementById('afontsize').value='13';
document.getElementById('abg0').checked="true";
document.getElementById('abgcolor').color.fromString('FFFFFF');
document.getElementById('post_image5').value='';
document.getElementById('abgsize').value='';
document.getElementById('abstyle').value='none';
document.getElementById('abwidth').value='';
document.getElementById('abcolor').color.fromString('');
document.getElementById('abradius').value='';
document.getElementById('post_image6').value='';
document.getElementById('post_image7').value='wp-content/plugins/spiderfaq/upload/style1/style1a.png';
document.getElementById('aimagewidth').value='';
document.getElementById('aimageheight').value='';
document.getElementById('aimagewidth2').value='512';
document.getElementById('aimageheight2').value='5';
document.getElementById('amarginimage2').value='';
document.getElementById('atxtcolor').color.fromString('44A9CF');
document.getElementById('expcolcolor').color.fromString('000000');
document.getElementById('expcolfontsize').value='14';
document.getElementById('expcolmargin').value='12 60 18 0';
document.getElementById('expcolhovercolor').color.fromString('8F8F8F');
document.getElementById('sformmargin').value='0 60 12 0';
document.getElementById('sboxwidth').value='300';
document.getElementById('sboxheight').value='25';
document.getElementById('showsbox0').checked="true";
document.getElementById('sboxbgcolor').color.fromString('');
document.getElementById('sboxbstyle').value='solid';
document.getElementById('sboxbwidth').value='2';
document.getElementById('sboxbcolor').color.fromString('A6A6A6');
document.getElementById('sboxfontsize').value='12';
document.getElementById('sboxtcolor').color.fromString('000000');
document.getElementById('srwidth').value='60';
document.getElementById('srheight').value='30';
document.getElementById('showsr0').checked="true";
document.getElementById('srbgcolor').color.fromString('');
document.getElementById('srbstyle').value='solid';
document.getElementById('srbwidth').value='2';
document.getElementById('srbcolor').color.fromString('828282');
document.getElementById('srfontsize').value='14';
document.getElementById('srfontweight').value='';
document.getElementById('srtcolor').color.fromString('000000');
document.getElementById('rmcolor').color.fromString('000000');
document.getElementById('rmhovercolor').color.fromString('9E9E9E');
document.getElementById('rmfontsize').value='12';

show_(2);
ctbg_(1);
ctbggrad_(1);
cdbg_(1);
cdbggrad_(0);
titlebg_(0);
titlebggrad_(0);
abg_(0);
showsbox_(0);
showsr_(0);

for(i=1; i<8; i++){
if(i==7)
continue;
else
document.getElementById('imagebox'+i).setAttribute("style","display:none");
}
}

}