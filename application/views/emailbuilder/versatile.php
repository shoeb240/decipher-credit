<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title style="-ko-bind-text: @titleText">TITLE</title>
  <style type="text/css">
    @supports -ko-blockdefs {
      id { widget: id }
      size { label: Size; widget: select; options: 8|9|10|11|12|13|14|15|16|18|20|22|25|28|31; }
      visible { label: Visible?; widget: boolean }
      color { label: Color; widget: color }
      radius {
        label: Corner Radius;
        widget: integer;
        max: 20;
        help: Attention - this property is not supported on all email clients (i.e. Outlook)
      }
      face { label: Font; widget: select; options: Arial, Helvetica, sans-serif=Arial|Arial Black, Arial Black, Gadget, sans-serif=Arial Black|Comic Sans MS, Comic Sans MS5, cursive=Comic Sans|Courier New, Courier New, monospace=Courier|Georgia, serif=Georgia|Impact, sans-serif=Impact|Lucida Console, Monaco, monospace=Lucida Console|Lucida Sans Unicode, Lucida Grande, sans-serif=Lucida Sans Unicode|Times New Roman, Times, serif=Times New Roman|Verdana, Geneva, sans-serif=Verdana}
      decoration { label: Decoration; widget: select; options: none=None|underline=Underline }
      linksColor { label: Link Color; extend: color }
      linksDecoration { label: Underlined Links?; extend: decoration }
      buttonColor { label: Button Color; extend: color }
      text { label: Paragraph; widget: text }
      url { label: Link; widget: url }
      src { label: Image; widget: src }
      hrWidth { label: Width; widget: select; options:10|20|30|40|50|60|70|80|90|100; }
      hrHeight { label: Line height; widget: integer; max: 80; }

      height { label: Height; widget: integer }
      imageHeight { label: Image Height; extend: height; }
      spacerSize { label: Height; widget: integer; max: 90; min: 4; }
      align { label: Alignment; widget: select; options:left=Left|right=Right|center=Center}
      alt {
        label: Alternative Text;
        widget: text;
        help: Alternative text will be shown on email clients that does not download image automatically;
      }
      sponsor { label: Sponsor; properties: visible=true src url alt; category: hidden }
      titleText {label:Title Text;category: hidden;}
      gutterVisible { label: Show Gutter; extend: visible }
      socialIconType { label: Icon Version;widget: select; options:bw=Black and White|colors=Colors; }

      preheaderLinkOption {
        label: Unsubscribe Link;
        widget: select;
        options: [profile_link]=Profile|[unsubscribe_link]=Unsubscribe|none=None;
        help: If -None- is selected, preHeader text will be shown;
      }

      hrStyle { label: Separator Style;properties:color hrWidth hrHeight; }
      hrStyle:preview { height: 200%; width: 200%; bottom: 20px; -ko-border-bottom: @[hrHeight]px solid @color; }
      preheaderVisible { label: Show Preheader; extend: visible; help: Preheader block is the first one on the top of the page. It contains web version link and optionally unsubscribe link or a preheader text that will be shown as a preview on some email clients; }

      /* content types */
      blocks { label: Blocks; properties: blocks[]; }
      link { label: Link; properties: text url }
      image { label: Image; properties: src url alt }
      backgroundColor { label: Background Color; extend: color }
      buttonLink { label: Button; extend: link }

      /* texts and links */
      textStyle { label: Text; properties: face color size }
      textStyle:preview { -ko-bind-text: @['AaZz']; -ko-font-family: @face; -ko-color: @color; -ko-font-size: @[size]px; }
      linkStyle { label: Link; properties: face color size decoration=none }
      linkStyle:preview { -ko-bind-text: @['Link']; -ko-font-size: @[size]px; -ko-font-family: @face; -ko-color: @color; -ko-text-decoration: @[decoration] }
      longTextStyle { label: Paragraph; properties: face color size linksColor   }
      longTextStyle:preview { -ko-bind-text: @['AaZz']; -ko-font-family: @face; -ko-color: @color; -ko-font-size: @[size]px; }
      bigButtonStyle { label: Big Button; extend: buttonStyle }
      titleTextStyle { label: Title; extend: textStyle }
      /* background */
      externalBackgroundColor { label: External Background; extend: color }

      externalTextStyle { label: Alternative Text; extend: textStyle }
      externalTextStyle:preview { -ko-bind-text: @['AaZz']; -ko-font-family: @face; -ko-color: @color; -ko-font-size: @[size]px; }

      bigTitleStyle { label: Title; properties: face color size align}
      bigTitleStyle:preview { -ko-bind-text: @['AaZz']; -ko-font-family: @face; -ko-color: @color; -ko-font-size: @[size]px; }
      /* buttons */
      buttonStyle color { label: Text Color; extend: color }
      buttonStyle size { label: Text Size; extend: size }
      buttonStyle { label: Button; properties: face color size buttonColor radius }
      buttonStyle:preview { -ko-bind-text: @['Button']; -ko-font-family: @face; -ko-color: @color; -ko-font-size: @[size]px; -ko-background-color: @buttonColor; padding-left: 5px; -ko-border-radius: @[radius]px; }

      /* contents */
      preheaderText {label: PreHeader Text; extend:text; help: This text will be shown on some email clients as a preview of the email contents;}
      leftImage { label: Left Image; extend: image }
      leftLongText { label: Left Text; extend: text }
      leftButtonLink { label: Left Button; extend: buttonLink }
      middleImage { label: Central Image; extend: image }
      middleLongText { label: Central Text; extend: text }
      middleButtonLink { label: Central Button; extend: buttonLink }
      rightImage { label: Right Image; extend: image }
      rightLongText { label: Right Text; extend: text }
      rightButtonLink { label: Right Button; extend: buttonLink }
      webversionText{ label: Web Link Text; extend: text;}
      unsubscribeText{ label: Unsubscribe Link; extend: text;}

      titleVisible { label: Show Title; extend: visible; }
      buttonVisible { label: Show Button; extend: visible; }
      imageVisible { label: Show Image; extend: visible; }

      contentTheme { label: Main Style; }
      contentTheme:preview { -ko-background-color: @[backgroundColor] }
      frameTheme { label: Frame Style; }
      frameTheme:preview { -ko-background-color: @[backgroundColor] }
      template preheaderText { label: Preheader; }

      template { label: Page; theme: frameTheme ;properties:  preheaderVisible=true; version: 1.0.5; }

      footerBlock { label: Unsubscribe Block; theme: frameTheme }

      socialBlock fbVisible { label: Facebook; }
      socialBlock twVisible { label: Twitter }
      socialBlock ggVisible { label: Google+ }
      socialBlock inVisible { label: LinkedIn }
      socialBlock flVisible { label: Flickr }
      socialBlock viVisible { label: Vimeo }
      socialBlock webVisible { label: Website }
      socialBlock instVisible { label: Instagram }
      socialBlock youVisible { label: YouTube }
      socialBlock fbUrl { label: Facebook Link}
      socialBlock twUrl { label: Twitter Link}
      socialBlock ggUrl { label: Google+ Link}
      socialBlock inUrl { label: LinkedIn Link}
      socialBlock flUrl { label: Flickr Link}
      socialBlock viUrl { label: Vimeo Link}
      socialBlock webUrl { label: Website Link}
      socialBlock instUrl { label: Instagram Link}
      socialBlock youUrl { label: YouTube Link}
      socialBlock {
        label: Social Block;
        properties: socialIconType=colors fbVisible=true fbUrl twVisible=true twUrl ggVisible=true ggUrl webVisible=false webUrl inVisible=false inUrl flVisible=false flUrl viVisible=false viUrl instVisible=false instUrl youVisible=false youUrl longTextStyle longText backgroundColor;
        variant:socialIconType;
        theme: frameTheme
      }

      preheaderBlock { label:Preheader Block;  theme: frameTheme}

      sideArticleBlock imagePos {label:Image position;widget:select; options: left=Left|right=Right; }
      sideArticleBlock imageWidth { label: Image Size; widget: select; options: 120=Small|166=Medium|258=Big; }
      sideArticleBlock { label: Image+Text Block; properties: backgroundColor titleVisible=true buttonVisible=true imageWidth=166 imagePos=left titleTextStyle longTextStyle buttonStyle  image  longText buttonLink; variant:imagePos; theme: contentTheme }

      textBlock { label: Text Block; properties: backgroundColor longTextStyle longText; theme: contentTheme}

      singleArticleBlock { label: Image/Text Block; properties: backgroundColor titleVisible=true buttonVisible=true imageVisible=true titleTextStyle longTextStyle buttonStyle  image  longText buttonLink;theme: contentTheme}

      doubleArticleBlock { label: 2 Columns Block; properties: backgroundColor titleVisible=true buttonVisible=true imageVisible=true titleTextStyle longTextStyle buttonStyle  leftImage  leftLongText leftButtonLink rightImage  rightLongText rightButtonLink; theme: contentTheme}

      tripleArticleBlock { label: 3 Columns Block; properties: backgroundColor titleVisible=true buttonVisible=true imageVisible=true titleTextStyle longTextStyle buttonStyle  leftImage  leftLongText leftButtonLink middleImage  middleLongText middleButtonLink rightImage  rightLongText rightButtonLink; theme: contentTheme}

      logoBlock imageWidth { label: Image Size; widget: select; options: 166=Small|258=Medium|350=Big; variant:imageWidth;}
      logoBlock { label: Logo Block; properties: image imageWidth=258; variant: imageWidth; theme: contentTheme}

      titleBlock { label: Title; theme: contentTheme}

      imageBlock longTextStyle {
        label: Alternative Text;
      }
      imageBlock { label: Image; properties: gutterVisible=false; variant: gutterVisible; theme: contentTheme }

      doubleImageBlock longTextStyle {
        label: Alternative Text;
      }
      doubleImageBlock { label: Two Image Gallery Block; properties: gutterVisible=false; variant: gutterVisible; theme: contentTheme }

      tripleImageBlock longTextStyle {
        label: Alternative Text;
      }
      tripleImageBlock { label: Three Image Gallery Block;properties:gutterVisible=false;variant:gutterVisible; theme: contentTheme}

      buttonBlock { label: Button Block; theme: contentTheme}
      hrBlock { label: Separator Block;  theme: contentTheme}
      spacerBlock { label: Spacer Block;  theme: contentTheme}

      spacerBlock:preview,
      logoBlock:preview { -ko-background-color: @[externalBackgroundColor] }

      preheaderBlock:preview,
      hrBlock:preview,
      sideArticleBlock:preview,
      textBlock:preview,
      singleArticleBlock:preview,
      doubleArticleBlock:preview,
      tripleArticleBlock:preview,
      titleBlock:preview,
      footerBlock:preview,
      socialBlock:preview,
      buttonBlock:preview,
      titleBlock:preview,
      socialshareBlock:preview { -ko-background-color: @[backgroundColor] }
    }
  </style>
  <style type="text/css" data-inline="true">
    body { Margin: 0; padding: 0; }
    img { border: 0px; display: block; }

    .socialLinks { font-size: 6px; }
    .socialLinks a {
      display: inline-block;
    }
    .socialIcon {
      display: inline-block;
      vertical-align: top;
      padding-bottom: 0px;
      border-radius: 100%;
    }
    .oldwebkit { max-width: 570px; }
    td.vb-outer { padding-left: 9px; padding-right: 9px; }
    table.vb-container, table.vb-row, table.vb-content {
      border-collapse: separate;
    }
    table.vb-row {
      border-spacing: 9px;
    }
    table.vb-row.halfpad {
      border-spacing: 0;
      padding-left: 9px;
      padding-right: 9px;
    }
    table.vb-row.fullwidth {
      border-spacing: 0;
      padding: 0;
    }
    table.vb-container {
      padding-left: 18px;
      padding-right: 18px;
    }
    table.vb-container.fullpad {
      border-spacing: 18px;
      padding-left: 0;
      padding-right: 0;
    }
    table.vb-container.halfpad {
      border-spacing: 9px;
      padding-left: 9px;
      padding-right: 9px;
    }
    table.vb-container.fullwidth {
      padding-left: 0;
      padding-right: 0;
    }
  </style>
  <style type="text/css">
    /* yahoo, hotmail */
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
    .yshortcuts a { border-bottom: none !important; }
    .vb-outer { min-width: 0 !important; }
    .RMsgBdy, .ExternalClass {
      width: 100%;
      background-color: #3f3f3f;
      -ko-background-color: @[_theme_.frameTheme.backgroundColor]
    }

    /* outlook */
    table { mso-table-rspace: 0pt; mso-table-lspace: 0pt; }
    #outlook a { padding: 0; }
    img { outline: none; text-decoration: none; border: none; -ms-interpolation-mode: bicubic; }
    a img { border: none; }

    @media screen and (max-device-width: 600px), screen and (max-width: 600px) {
      table.vb-container, table.vb-row {
        width: 95% !important;
      }

      .mobile-hide { display: none !important; }
      .mobile-textcenter { text-align: center !important; }

      .mobile-full {
        float: none !important;
        width: 100% !important;
        max-width: none !important;
        padding-right: 0 !important;
        padding-left: 0 !important;
      }
      img.mobile-full {
        width: 100% !important;
        max-width: none !important;
        height: auto !important;
      }
    }
  </style>
  <style type="text/css" data-inline="true">
    [data-ko-block=tripleArticleBlock] .links-color a,
    [data-ko-block=tripleArticleBlock] .links-color a:link,
    [data-ko-block=tripleArticleBlock] .links-color a:visited,
    [data-ko-block=tripleArticleBlock] .links-color a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=tripleArticleBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=tripleArticleBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=tripleArticleBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=doubleArticleBlock] .links-color a,
    [data-ko-block=doubleArticleBlock] .links-color a:link,
    [data-ko-block=doubleArticleBlock] .links-color a:visited,
    [data-ko-block=doubleArticleBlock] .links-color a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=doubleArticleBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=doubleArticleBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=doubleArticleBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=singleArticleBlock] .links-color a,
    [data-ko-block=singleArticleBlock] .links-color a:link,
    [data-ko-block=singleArticleBlock] .links-color a:visited,
    [data-ko-block=singleArticleBlock] .links-color a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=singleArticleBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=singleArticleBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=singleArticleBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=textBlock] .links-color a,
    [data-ko-block=textBlock] .links-color a:link,
    [data-ko-block=textBlock] .links-color a:visited,
    [data-ko-block=textBlock] .links-color a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=textBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=textBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=textBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=sideArticleBlock] .links-color a,
    [data-ko-block=sideArticleBlock] .links-color a:link,
    [data-ko-block=sideArticleBlock] .links-color a:visited,
    [data-ko-block=sideArticleBlock] .links-color a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=sideArticleBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=sideArticleBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=sideArticleBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=socialBlock] .links-color a,
    [data-ko-block=socialBlock] .links-color a:link,
    [data-ko-block=socialBlock] .links-color a:visited,
    [data-ko-block=socialBlock] .links-color a:hover {
      color: #cccccc;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=socialBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=socialBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=socialBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=footerBlock] .links-color a,
    [data-ko-block=footerBlock] .links-color a:link,
    [data-ko-block=footerBlock] .links-color a:visited,
    [data-ko-block=footerBlock] .links-color a:hover {
      color: #cccccc;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=footerBlock] .long-text p { Margin: 1em 0px; }
    [data-ko-block=footerBlock] .long-text p:last-child { Margin-bottom: 0px; }
    [data-ko-block=footerBlock] .long-text p:first-child { Margin-top: 0px; }

    [data-ko-block=doubleImageBlock] a,
    [data-ko-block=doubleImageBlock] a:link,
    [data-ko-block=doubleImageBlock] a:visited,
    [data-ko-block=doubleImageBlock] a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=tripleImageBlock] a,
    [data-ko-block=tripleImageBlock] a:link,
    [data-ko-block=tripleImageBlock] a:visited,
    [data-ko-block=tripleImageBlock] a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
    [data-ko-block=imageBlock] a,
    [data-ko-block=imageBlock] a:link,
    [data-ko-block=imageBlock] a:visited,
    [data-ko-block=imageBlock] a:hover {
      color: #3f3f3f;
      -ko-color: @longTextStyle.linksColor;
      text-decoration: underline;
    }
  </style>
</head>
<body bgcolor="#3f3f3f" text="#919191" alink="#cccccc" vlink="#cccccc" style="background-color: #3f3f3f; color: #919191;
  -ko-background-color: @_theme_.frameTheme.backgroundColor; -ko-attr-bgcolor: @_theme_.frameTheme.backgroundColor; -ko-color: @_theme_.frameTheme.longTextStyle.color;
  -ko-attr-text: @_theme_.frameTheme.longTextStyle.color; -ko-attr-alink: @_theme_.frameTheme.longTextStyle.linksColor;
  -ko-attr-vlink: @_theme_.frameTheme.longTextStyle.linksColor">

  <center>

  <!-- preheaderBlock -->
  <div data-ko-display="preheaderVisible" data-ko-wrap="false">

  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#3f3f3f"
    style="background-color: #3f3f3f; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor" data-ko-block="preheaderBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#3f3f3f"
        style="background-color: #3f3f3f; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor">
        <div style="display: none; font-size:1px; color: #333333; line-height: 1px; max-height:0px; max-width: 0px; opacity: 0; overflow: hidden;
          -ko-bind-text: @preheaderText"></div>

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="0" class="vb-row halfpad" bgcolor="#3f3f3f"
          style="width: 100%; max-width: 570px; background-color: #3f3f3f; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td align="center" valign="top" bgcolor="#3f3f3f" style="font-size: 0; background-color: #3f3f3f;
              -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor" align="left">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="276"><![endif]-->
<div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">
                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="276" style="width: 100%;" align="left">
                      <tr>
                        <td width="100%" valign="top" align="left" style="font-weight: normal; text-align:left; font-size: 13px;
                          font-family: Arial, Helvetica, sans-serif; color: #ffffff;
                          -ko-font-size: @[linkStyle.size]px; -ko-color: @linkStyle.color; -ko-font-family: @linkStyle.face">
                          <a data-ko-display="preheaderLinkOption neq 'none'" data-ko-editable="unsubscribeText" href="[unsubscribe_link]"
                             style="text-decoration: underline; color: #ffffff; -ko-attr-href: @preheaderLinkOption;
                             -ko-color: @linkStyle.color; -ko-text-decoration: @linkStyle.decoration">Unsubscribe</a>
                          <span data-ko-display="preheaderLinkOption eq 'none'" style="font-size: 13px;color: #919191; font-weight: normal; text-align:center;
                            font-family: Arial, Helvetica, sans-serif; -ko-font-size: @[longTextStyle.size]px; -ko-color: @longTextStyle.color;
                            -ko-font-family: @longTextStyle.face; -ko-bind-text: @preheaderText; display: none"></span>
                        </td>
                      </tr>
                    </table>
</div><!--[if (gte mso 9)|(lte ie 8)]>
</td><td align="left" valign="top" width="276">
<![endif]--><div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full mobile-hide">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="276" style="width: 100%; text-align: right;" align="left">
                      <tr>
                        <td width="100%" valign="top" style="font-weight: normal;  font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #ffffff;
                      -ko-font-size: @[linkStyle.size]px; -ko-color: @linkStyle.color; -ko-font-family: @linkStyle.face">
                      <span style="color: #ffffff; text-decoration: underline;
                        -ko-color: @linkStyle.color; -ko-text-decoration: @linkStyle.decoration">
                          <a data-ko-editable="webversionText" href="[show_link]"
                          style="text-decoration: underline; color: #ffffff;
                           -ko-color: @linkStyle.color; -ko-text-decoration: @linkStyle.decoration">View in your browser</a>
                         </span>
                       </td>
                      </tr>
                    </table>

</div><!--[if (gte mso 9)|(lte ie 8)]>
</td></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>

  </div>
  <!-- /preheaderBlock -->

  <div data-ko-container="main" data-ko-wrap="false">

  <!-- logoBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="logoBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" style="width: 100%; max-width: 570px" border="0" cellpadding="0" cellspacing="18" class="vb-container fullpad">
          <tr>
            <td valign="top" align="center">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="258" style="-ko-attr-width: @[imageWidth]"><tr><td align="center" valign="top"><![endif]-->
<div style="display:inline-block; max-width:258px; -ko-max-width: @[imageWidth]px; vertical-align:top; width:100%;" class="mobile-full">
                    <a data-ko-link="image.url" href="" style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #f3f3f3;
                      text-decoration: none; -ko-font-size: @[externalTextStyle.size]px;
                      -ko-font-family: @externalTextStyle.face; -ko-color: @externalTextStyle.color"><img
                       data-ko-editable="image.src" width="258" data-ko-placeholder-height="150"
                        style="-ko-attr-alt: @image.alt; width: 100%; max-width: 258px; -ko-attr-width: @imageWidth; -ko-max-width: @[imageWidth]px;"
                        src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=258%2C150" vspace="0" hspace="0" border="0" alt="" /></a>
</div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->

      </td>
    </tr>
  </table>
  <!-- /logoBlock  -->

  <!-- sideArticleBlock  -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="sideArticleBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="9" class="vb-row fullpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td align="center" class="mobile-row" valign="top" style="font-size: 0;">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<div data-ko-display="imagePos eq 'left'" data-ko-wrap="false" style="width: 100%; max-width:184px; -ko-max-width:@[18 + Math.round(imageWidth)]px; display:inline-block" class="mobile-full">
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="184" style="-ko-attr-width: @[18 + Math.round(imageWidth)]"><![endif]-->
<div style="display:inline-block; max-width:184px; -ko-max-width:@[18 + Math.round(imageWidth)]px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="184" style="width: 100%; -ko-attr-width: @[18 + Math.round(imageWidth)]" align="left">
                      <tr>
                        <td width="100%" valign="top" align="left" class="links-color">
                          <a data-ko-link="image.url" href="">
                            <img data-ko-editable="image.src" border="0" hspace="0" vspace="0" width="166"
                              data-ko-placeholder-height="130" class="mobile-full" alt=""
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C130"
                              style="vertical-align: top; width: 100%; height: auto; -ko-attr-width: @imageWidth; max-width: 166px; -ko-max-width: @[imageWidth]px; -ko-attr-alt: @image.alt" />
                          </a>
                        </td>
                      </tr>
                    </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<![endif]--></div><!--[if (gte mso 9)|(lte ie 8)]>
<td align="left" valign="top" width="368" style="-ko-attr-width: @[570 - 2 * 18 - Math.round(imageWidth)]">
<![endif]--><div style="display:inline-block; max-width:368px; -ko-max-width: @[570 - 2 * 18 - Math.round(imageWidth)]px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="368" style="width: 100%; -ko-attr-width: @[570 - 2 * 18 - Math.round(imageWidth)]" align="left">
                      <tr data-ko-display="titleVisible">
                        <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                          -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                          <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color" data-ko-editable="titleText">
                          Title
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="longText" class="long-text links-color">
                          <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                        </td>
                      </tr>
                      <tr data-ko-display="buttonVisible">
                        <td valign="top">
                          <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full" style="padding-top: 4px">
                            <tr>
                              <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                                style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                                padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                                -ko-border-radius: @[buttonStyle.radius]px;
                                -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                                -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color;">
                                <a data-ko-editable="buttonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                                  -ko-color: @buttonStyle.color; -ko-attr-href: @buttonLink.url">BUTTON</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<![endif]--><div data-ko-display="imagePos eq 'right'" data-ko-wrap="false" style="width: 100%; max-width:184px; -ko-max-width:@[18 + Math.round(imageWidth)]px; display:inline-block; display: none;" class="mobile-full"><!--[if (gte mso 9)|(lte ie 8)]>
<td data-ko-display="imagePos eq 'right'" align="left" valign="top" width="184" style="display: none; -ko-attr-width: @[18 + Math.round(imageWidth)]">
<![endif]--><div style="display:inline-block; max-width:184px; -ko-max-width:@[18 + Math.round(imageWidth)]px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="184" style="width: 100%; -ko-attr-width: @[18 + Math.round(imageWidth)]" align="left">
                      <tr>
                        <td width="100%" valign="top" align="left" class="links-color">
                          <a data-ko-link="image.url" href="">
                            <img data-ko-editable="image.src" border="0" hspace="0" vspace="0" width="166" data-ko-placeholder-height="130" class="mobile-full"
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C130" class="mobile-full"
                              alt="" style="vertical-align:top; width: 100%; height: auto; -ko-attr-width: @imageWidth; max-width: 166px; -ko-max-width: @[imageWidth]px; -ko-attr-alt: @image.alt" />
                          </a>
                        </td>
                      </tr>
                    </table>

</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
</div>
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /sideArticleBlock -->

  <!-- singleArticleBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="singleArticleBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="18" class="vb-container fullpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr data-ko-display="imageVisible">
            <td width="100%" valign="top" align="left" class="links-color">
              <a data-ko-link="image.url" href="">
                <img data-ko-editable="image.src" border="0" hspace="0" vspace="0" width="534" data-ko-placeholder-height="200"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=534%2C200" class="mobile-full"
                  alt="" style="vertical-align:top; max-width:534px; width: 100%; height: auto;
                  -ko-attr-alt: @image.alt" />
              </a>
            </td>
          </tr>
          <tr><td><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr data-ko-display="titleVisible">
              <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color" data-ko-editable="text">
               Section Title
                </span>
              </td>
            </tr>
            <tr data-ko-display="titleVisible">
              <td height="9" style="font-size:1px; line-height: 1px;">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                data-ko-editable="longText" class="long-text links-color">
                <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </td>
            </tr>
            <tr data-ko-display="buttonVisible">
              <td height="13" style="font-size:1px; line-height: 1px;">&nbsp;</td>
            </tr>
            <tr data-ko-display="buttonVisible">
              <td valign="top">
                <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full">
                  <tr>
                    <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                      style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                      padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                      -ko-border-radius: @[buttonStyle.radius]px;
                      -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                      -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color; ">
                      <a data-ko-editable="buttonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                        -ko-color: @buttonStyle.color; -ko-attr-href: @buttonLink.url">BUTTON</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table></td></tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /singleArticleBlock -->

  <!-- TitleBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="titleBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="9" class="vb-container halfpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td bgcolor="#ffffff" align="center"
              style="background-color: #ffffff; font-size: 22px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align: center;
              -ko-attr-align: @bigTitleStyle.align; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;
              -ko-font-size: @[bigTitleStyle.size]px; -ko-font-family: @bigTitleStyle.face; -ko-color: @bigTitleStyle.color; -ko-text-align: @bigTitleStyle.align">
              <span data-ko-editable="text">Section Title</span>
            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /TitleBlock -->

  <!-- textBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="textBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="18" class="vb-container fullpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
              -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
              data-ko-editable="longText" class="long-text links-color">
              <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts.</p>
              <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /textBlock -->

  <!-- tripleArticleBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="tripleArticleBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="9" class="vb-row fullpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td align="center" valign="top" class="mobile-row" style="font-size: 0">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="184"><![endif]-->
<div style="display:inline-block; max-width:184px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="184" style="width: 100%" align="left">
                      <tr data-ko-display="imageVisible">
                        <td width="100%" valign="top" align="left" class="links-color" style="padding-bottom: 9px">
                          <a data-ko-link="leftImage.url" href="">
                            <img data-ko-editable="leftImage.src" border="0" hspace="0" vspace="0" width="166" height="90"
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C90" class="mobile-full"
                             alt="" style="vertical-align:top; width: 100%; height: auto; -ko-attr-height: @imageHeight;
                               -ko-attr-alt: @leftImage.alt" />
                          </a>
                        </td>
                      </tr>
                      <tr data-ko-display="titleVisible">
                        <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                          -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                          <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color" data-ko-editable="leftTitleText">Title
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="leftLongText" class="long-text links-color">
                          <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts. </p>
                        </td>
                      </tr>
                      <tr data-ko-display="buttonVisible">
                        <td valign="top">
                          <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full" style="padding-top: 4px">
                            <tr>
                              <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                                style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                                padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                                -ko-border-radius: @[buttonStyle.radius]px;
                                -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                                -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color; ">
                                <a data-ko-editable="leftButtonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                                  -ko-color: @buttonStyle.color; -ko-attr-href: @leftButtonLink.url">BUTTON</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="184">
<![endif]--><div style="display:inline-block; max-width:184px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="184" style="width: 100%" align="left">
                      <tr data-ko-display="imageVisible">
                        <td width="100%" valign="top" align="left" class="links-color" style="padding-bottom: 9px">
                          <a data-ko-link="middleImage.url">
                            <img data-ko-editable="middleImage.src" border="0" hspace="0" vspace="0" width="166" height="90"
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C90" class="mobile-full"
                              alt="" style="vertical-align:top; width: 100%; height: auto; -ko-attr-height: @imageHeight;
                              -ko-attr-alt: @middleImage.alt" />
                          </a>
                        </td>
                      </tr>
                      <tr data-ko-display="titleVisible">
                        <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                          -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                          <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color"  data-ko-editable="middleTitleText">
                         Title
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="middleLongText" class="long-text links-color">
                          <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts. </p>
                        </td>
                      </tr>
                      <tr data-ko-display="buttonVisible">
                        <td valign="top">
                          <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full" style="padding-top: 4px">
                            <tr>
                              <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                                style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                                padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                                -ko-border-radius: @[buttonStyle.radius]px;
                                -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                                -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color; ">
                                <a data-ko-editable="middleButtonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                                  -ko-color: @buttonStyle.color; -ko-attr-href: @middleButtonLink.url">BUTTON</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="184">
<![endif]--><div style="display:inline-block; max-width:184px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="184" style="width: 100%" align="right">
                      <tr data-ko-display="imageVisible">
                        <td width="100%" valign="top" align="left" class="links-color" style="padding-bottom: 9px">
                          <a data-ko-link="rightImage.url">
                            <img data-ko-editable="rightImage.src" border="0" hspace="0" vspace="0" width="166" height="90"
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C90" class="mobile-full"
                              alt="" style="vertical-align:top; width: 100%; height: auto; -ko-attr-height: @imageHeight;
                              -ko-attr-alt: @rightImage.alt" />
                          </a>
                        </td>
                      </tr>
                      <tr data-ko-display="titleVisible">
                        <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                          -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                          <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color" data-ko-editable="rightTitleText">
                         Title
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="rightLongText" class="long-text links-color">
                          <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts. </p>
                        </td>
                      </tr>
                      <tr data-ko-display="buttonVisible">
                        <td valign="top">
                          <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full" style="padding-top: 4px">
                            <tr>
                              <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                                style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                                padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                                -ko-border-radius: @[buttonStyle.radius]px;
                                -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                                -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color;">
                                <a data-ko-editable="rightButtonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                                  -ko-color: @buttonStyle.color; -ko-attr-href: @rightButtonLink.url">BUTTON</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /tripleArticleBlock -->

  <!-- doubleArticleBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="doubleArticleBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="9" class="vb-row fullpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td align="center" valign="top" style="font-size: 0">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="276"><![endif]-->
<div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="276" style="width: 100%" align="left">
                      <tr data-ko-display="imageVisible">
                        <td width="100%" align="left" class="links-color" style="padding-bottom: 9px">
                          <a data-ko-link="leftImage.url">
                            <img data-ko-editable="leftImage.src" border="0" hspace="0" vspace="0" width="258" height="100"
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=258%2C100" class="mobile-full"
                              alt="" style="vertical-align:top; width: 100%; height: auto; -ko-attr-height: @imageHeight;
                              -ko-attr-alt: @leftImage.alt" />
                          </a>
                        </td>
                      </tr>
                      <tr data-ko-display="titleVisible">
                        <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                          -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                          <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color" data-ko-editable="leftTitleText">
                          Title
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="leftLongText" class="long-text links-color">
                          <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts. </p>
                        </td>
                      </tr>
                      <tr data-ko-display="buttonVisible">
                        <td valign="top">
                          <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full" style="padding-top: 4px;">
                            <tr>
                              <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                                style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                                padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                                -ko-border-radius: @[buttonStyle.radius]px;
                                -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                                -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color; ">
                                <a data-ko-editable="leftButtonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                                  -ko-color: @buttonStyle.color; -ko-attr-href: @leftButtonLink.url">BUTTON</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="276">
<![endif]--><div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="276" style="width: 100%" align="right">
                      <tr data-ko-display="imageVisible">
                        <td width="100%" valign="top" align="left" class="links-color" style="padding-bottom: 9px">
                          <a data-ko-link="rightImage.url">
                            <img data-ko-editable="rightImage.src" border="0" hspace="0" vspace="0" width="258" height="100"
                              src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=258%2C100" class="mobile-full"
                              alt="" style="vertical-align:top; width: 100%; height: auto; -ko-attr-height: @imageHeight;
                              -ko-attr-alt: @rightImage.alt" />
                          </a>
                        </td>
                      </tr>
                      <tr data-ko-display="titleVisible">
                        <td style="font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; text-align:left;
                          -ko-font-size: @[titleTextStyle.size]px; -ko-font-family: @titleTextStyle.face; -ko-color: @titleTextStyle.color">
                          <span style="color: #3f3f3f; -ko-color: @titleTextStyle.color" data-ko-editable="rightTitleText">
                         Title
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" style="text-align: left; font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="rightLongText" class="long-text links-color">
                          <p>Far far away, behind the word mountains, far from the countries <a href="">Vokalia and Consonantia</a>, there live the blind texts.</p>
                        </td>
                      </tr>
                      <tr data-ko-display="buttonVisible">
                        <td valign="top">
                          <table cellpadding="0" border="0" align="left" cellspacing="0" class="mobile-full" style="padding-top: 4px;">
                            <tr>
                              <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="26"
                                style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; text-align:center; color: #3f3f3f; font-weight: normal;
                                padding-left: 18px; padding-right: 18px; background-color: #bfbfbf; border-radius: 4px;
                                -ko-border-radius: @[buttonStyle.radius]px;
                                -ko-attr-bgcolor: @buttonStyle.buttonColor; -ko-background-color: @buttonStyle.buttonColor;
                                -ko-font-size: @[buttonStyle.size]px; -ko-font-family: @buttonStyle.face; -ko-color: @buttonStyle.color; ">
                                <a data-ko-editable="rightButtonLink.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                                  -ko-color: @buttonStyle.color; -ko-attr-href: @rightButtonLink.url">BUTTON</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /doubleArticleBlock -->

  <!-- hrBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="hrBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="9" class="vb-container halfpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td valign="top" bgcolor="#ffffff" style="background-color: #ffffff;
              -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor" align="center">
              <table width="100%" cellspacing="0" cellpadding="0" border="0"
                style="width:100%; -ko-width: @[hrStyle.hrWidth]%; -ko-attr-width: @[hrStyle.hrWidth]%">
                <tr>
                  <td width="100%" height="1" style="font-size:1px; line-height: 1px; width: 100%; background-color: #3f3f3f;
                  -ko-background-color: @hrStyle.color; -ko-attr-height: @hrStyle.hrHeight; -ko-line-height: @[hrStyle.hrHeight]px">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /hrBlock -->

  <!-- buttonBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor"  data-ko-block="buttonBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" border="0" cellpadding="0" cellspacing="18" class="vb-container fullpad" bgcolor="#ffffff"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
          <tr>
            <td valign="top" bgcolor="#ffffff" style="background-color: #ffffff;
              -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor" align="center">

              <table cellpadding="0" border="0" align="center" cellspacing="0" class="mobile-full">
                <tr>
                  <td width="auto" valign="middle" bgcolor="#bfbfbf" align="center" height="50"
                    style="font-size:22px; font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; font-weight: normal;
                    padding-left: 14px; padding-right: 14px; background-color: #bfbfbf; border-radius: 4px;
                    -ko-attr-bgcolor: @bigButtonStyle.buttonColor; -ko-background-color: @bigButtonStyle.buttonColor;
                     -ko-border-radius: @[bigButtonStyle.radius]px;
                    -ko-font-size: @[bigButtonStyle.size]px; -ko-font-family: @bigButtonStyle.face; -ko-color: @bigButtonStyle.color; ">
                    <a data-ko-link="link.url" data-ko-editable="link.text" href="" style="text-decoration: none; color: #3f3f3f; font-weight: normal;
                      -ko-color: @bigButtonStyle.color;">BUTTON</a>
                  </td>
                </tr>
              </table>

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /buttonBlock -->

  <!-- imageBlock  -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf" style="background-color: #bfbfbf;
    -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="imageBlock">
    <tr>
      <td class="vb-outer" valign="top" align="center">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table data-ko-display="gutterVisible eq false" width="570" class="vb-container fullwidth" cellpadding="0" border="0" bgcolor="#ffffff" align="center"
          cellspacing="0" style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor;">
          <tr>
            <td valign="top" align="center">
              <a data-ko-link="image.url" href="" style="text-decoration: none;"><img data-ko-editable="image.src"
                  hspace="0" border="0" vspace="0" width="570" data-ko-placeholder-height="200"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=570%2C200" class="mobile-full"
                  alt="" style="max-width: 570px; display: block; border-radius: 0px; width: 100%; height: auto; font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px;
                  -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color; -ko-attr-alt: @image.alt;" /></a>
            </td>
          </tr>
        </table>
        <table data-ko-display="gutterVisible" width="570" class="vb-container fullpad" cellpadding="0" border="0" bgcolor="#ffffff" align="center"
          cellspacing="18" style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor; display: none;">
          <tr>
            <td valign="top" align="center">
              <a data-ko-link="image.url" href="" style="text-decoration: none;"><img data-ko-editable="image.src"
                  hspace="0" border="0" vspace="0" width="534" data-ko-placeholder-height="280"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=534%2C280" class="mobile-full"
                  alt="" style="max-width: 534px; display: block; border-radius: 0px; width: 100%; height: auto; font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px;
                  -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color; -ko-attr-alt: @image.alt;" /></a>
            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- imageBlock -->

  <!-- doubleImageBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf" style="background-color: #bfbfbf;
    -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="doubleImageBlock">
    <tr>
      <td class="vb-outer" align="center" valign="top" bgcolor="#bfbfbf"
        style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor">
<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table data-ko-display="gutterVisible eq false" width="570" class="vb-container fullwidth" cellpadding="0" border="0" bgcolor="#ffffff" align="center"
          cellspacing="0" style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor;">
          <tr>
            <td valign="top" align="center" class="mobile-row" style="font-size: 0">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="285"><![endif]-->
<div style="display:inline-block; max-width:285px; vertical-align:top; width:100%; width:100%; " class="mobile-full">
              <a data-ko-link="leftImage.url" href="" style="text-decoration: none;"><img data-ko-editable="leftImage.src"
                  hspace="0" align="left" border="0" vspace="0" width="285" height="180" class="mobile-full"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=285%2C180"
                  alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                  -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @leftImage.alt;" /></a>
</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="285">
<![endif]--><div style="display:inline-block; max-width:285px; vertical-align:top; width:100%; width:100%; " class="mobile-full">
              <a data-ko-link="rightImage.url" href="" style="text-decoration: none;"><img data-ko-editable="rightImage.src"
                  hspace="0" align="right" border="0" vspace="0" width="285" height="180" class="mobile-full"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=285%2C180"
                  alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                  -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @rightImage.alt;" /></a>
</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->
            </td>
          </tr>
        </table>
        <table data-ko-display="gutterVisible" width="570" class="vb-row fullpad" border="0" cellpadding="0" cellspacing="9" bgcolor="#ffffff"
            style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor; display: none;">
          <tr>
            <td align="center" valign="top" bgcolor="#ffffff" style="background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor; font-size: 0">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="276"><![endif]-->
<div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">

              <table class="vb-content" width="276" style="width: 100%" border="0" cellpadding="0" cellspacing="9" align="left">
                <tr>
                  <td valign="top">
                    <a data-ko-link="leftImage.url" href="" style="text-decoration: none;">
                      <img data-ko-editable="leftImage.src"
                        hspace="0" align="left" border="0" vspace="0" width="258" height="180"
                        src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=258%2C180" class="mobile-full"
                        alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                        font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                        -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @leftImage.alt;" /></a>
                  </td>
                </tr>
              </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="276">
<![endif]--><div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">

              <table class="vb-content" width="276" style="width: 100%" border="0" cellpadding="0" cellspacing="9" align="right">
                <tr>
                  <td valign="top">
                    <a data-ko-link="rightImage.url" href="" style="text-decoration: none;"><img data-ko-editable="rightImage.src"
                        hspace="0" align="right" border="0" vspace="0" width="258" height="180"
                        src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=258%2C180" class="mobile-full"
                        alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                        font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                        -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @rightImage.alt;" /></a>
                  </td>
                </tr>
              </table>

</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /doubleImageBlock -->

  <!--  tripleImageBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf" style="background-color: #bfbfbf;
    -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="tripleImageBlock">
    <tr>
      <td class="vb-outer" valign="top" align="center" style="">
<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table data-ko-display="gutterVisible eq false" width="570" class="vb-container fullwidth" cellpadding="0" border="0" bgcolor="#ffffff" align="center"
          cellspacing="0" style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor;">
          <tr>
            <td valign="top" align="center" class="mobile-row" style="font-size: 0">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="190"><![endif]-->
<div style="display:inline-block; max-width:190px; vertical-align:top; width:100%; " class="mobile-full">
              <a data-ko-link="leftImage.url" href="" style="text-decoration: none;"><img data-ko-editable="leftImage.src"
                  hspace="0" align="left" border="0" vspace="0" width="190" height="160" class="mobile-full"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=190%2C160"
                  alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                  -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @leftImage.alt;" /></a>
</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="190">
<![endif]--><div style="display:inline-block; max-width:190px; vertical-align:top; width:100%; " class="mobile-full">
              <a data-ko-link="middleImage.url" href="" style="text-decoration: none;"><img data-ko-editable="middleImage.src"
                  hspace="0" align="left" border="0" vspace="0" width="190" height="160" class="mobile-full"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=190%2C160"
                  alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                  -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @middleImage.alt;" /></a>
</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="190">
<![endif]--><div style="display:inline-block; max-width:190px; vertical-align:top; width:100%; " class="mobile-full">
              <a data-ko-link="rightImage.url" href="" style="text-decoration: none;"><img data-ko-editable="rightImage.src"
                  hspace="0" align="right" border="0" vspace="0" width="190" height="160" class="mobile-full"
                  src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=190%2C160"
                  alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                  font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                  -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @rightImage.alt;" /></a>
</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->
            </td>
          </tr>
        </table>
        <table data-ko-display="gutterVisible" width="570" border="0" cellpadding="0" cellspacing="9" bgcolor="#ffffff" class="vb-row fullpad"
          style="width: 100%; max-width: 570px; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor; display: none;">
          <tr>
            <td align="center" valign="top" bgcolor="#ffffff" style="font-size: 0; background-color: #ffffff; -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="184"><![endif]-->
<div style="display:inline-block; max-width:184px; vertical-align:top; width:100%;" class="mobile-full">

              <table class="vb-content" width="184" style="width: 100%" border="0" cellpadding="0" cellspacing="9" align="left">
                <tr>
                  <td valign="top">
                    <a data-ko-link="leftImage.url" href="" style="text-decoration: none;"><img data-ko-editable="leftImage.src"
                      hspace="0" align="left" border="0" vspace="0" width="166" height="160"
                      src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C160" class="mobile-full"
                      alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                      font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                      -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @leftImage.alt;" /></a>
                  </td>
                </tr>
              </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="184">
<![endif]--><div style="display:inline-block; max-width:184px; vertical-align:top; width:100%;" class="mobile-full">

              <table class="vb-content" width="184" style="width: 100%" border="0" cellpadding="0" cellspacing="9" align="left">
                <tr>
                  <td valign="top">
                    <a data-ko-link="middleImage.url" href="" style="text-decoration: none"><img data-ko-editable="middleImage.src"
                      hspace="0" align="left" border="0" vspace="0" width="166" height="160"
                      src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C160" class="mobile-full"
                      alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                      font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                      -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @middleImage.alt;" /></a>
                  </td>
                </tr>
              </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="184">
<![endif]--><div style="display:inline-block; max-width:184px; vertical-align:top; width:100%;" class="mobile-full">

              <table class="vb-content" width="184" style="width: 100%" border="0" cellpadding="0" cellspacing="9" align="right">
                <tr>
                  <td valign="top">
                    <a data-ko-link="rightImage.url" href="" style="text-decoration: none"><img data-ko-editable="rightImage.src"
                      hspace="0" align="right" border="0" vspace="0" width="166" height="160"
                      src="http://mosaico.io/srv/f-default/img?method=placeholder&amp;params=166%2C160" class="mobile-full"
                      alt="" style="display: block; border-radius: 0px; width: 100%; height: auto;font-size: 13px;
                      font-family: Arial, Helvetica, sans-serif; color: #3f3f3f; -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face;
                      -ko-color: @longTextStyle.color; -ko-attr-height: @imageHeight; -ko-attr-alt: @rightImage.alt;" /></a>
                  </td>
                </tr>
              </table>

</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /tripleImageBlock -->

  <!-- spacerBlock -->
  <table class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#bfbfbf"
    style="background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor; -ko-attr-bgcolor: @externalBackgroundColor" data-ko-block="spacerBlock">
    <tr>
      <td class="vb-outer" valign="top" align="center" bgcolor="#bfbfbf" height="24"
        style="-ko-attr-height: @spacerSize; height: 24px; -ko-height: @[spacerSize]px; background-color: #bfbfbf; -ko-background-color: @externalBackgroundColor;
        -ko-attr-bgcolor: @externalBackgroundColor; font-size:1px; line-height: 1px;">&nbsp;</td>
    </tr>
  </table>
  <!-- /spacerBlock -->

  <!-- socialBlock -->
  <table width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#3f3f3f"
    style="background-color: #3f3f3f; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor"  data-ko-block="socialBlock">
    <tr>
      <td align="center" valign="top" bgcolor="#3f3f3f" style="background-color: #3f3f3f;
        -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor;">
<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" style="width: 100%; max-width: 570px" border="0" cellpadding="0" cellspacing="9" class="vb-row fullpad" align="center">
          <tr>
            <td valign="top"  align="center" style="font-size: 0;">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="552"><tr><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]><td align="left" valign="top" width="276"><![endif]-->
<div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="276" style="width: 100%" align="left">
                      <tr>
                        <td valign="middle" align="left"
                          style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #919191; text-align:left;
                          -ko-font-size: @[longTextStyle.size]px; -ko-font-family: @longTextStyle.face; -ko-color: @longTextStyle.color"
                          data-ko-editable="longText" class="long-text links-color mobile-textcenter">
                          <p>Address and <a href="">Contacts</a></p>
                        </td>
                      </tr>
                    </table>

</div><!--[if (gte mso 9)|(lte ie 8)]></td>
<td align="left" valign="top" width="276">
<![endif]--><div style="display:inline-block; max-width:276px; vertical-align:top; width:100%;" class="mobile-full">

                    <table class="vb-content" border="0" cellspacing="9" cellpadding="0" width="276" style="width: 100%" align="right">
                      <tr>
                        <td align="right" valign="middle" class="links-color socialLinks mobile-textcenter" data-ko-display="socialIconType eq 'colors'">
                          <span data-ko-display="fbVisible" data-ko-wrap="false">&nbsp;</span>
                          <a data-ko-display="fbVisible" href="" style="-ko-attr-href: @fbUrl">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/facebook_ok.png" alt="Facebook" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="twVisible" data-ko-wrap="false">&nbsp;</span>
                          <a data-ko-display="twVisible" href="" style="-ko-attr-href: @twUrl">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/twitter_ok.png" alt="Twitter" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="ggVisible" data-ko-wrap="false">&nbsp;</span>
                          <a data-ko-display="ggVisible" href="" style="-ko-attr-href: @ggUrl">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/google+_ok.png" alt="Google+" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="webVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="webVisible" href="" style="-ko-attr-href: @webUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/web_ok.png" alt="Web" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="inVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="inVisible" href="" style="-ko-attr-href: @inUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/linkedin_ok.png" alt="Linkedin" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="flVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="flVisible" href="" style="-ko-attr-href: @flUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/flickr_ok.png" alt="Flickr" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="viVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="viVisible" href="" style="-ko-attr-href: @viUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/vimeo_ok.png" alt="Vimeo" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="instVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="instVisible" href="" style="-ko-attr-href: @instUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/instagram_ok.png" alt="Instagram" border="0"  class="socialIcon" />
                          </a>
                          <span data-ko-display="youVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="youVisible" href="" style="-ko-attr-href: @youUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/youtube_ok.png" alt="Youtube" border="0" class="socialIcon" />
                          </a>
                        </td>
                        <td align="right" valign="middle" class="links-color socialLinks mobile-textcenter" data-ko-display="socialIconType eq 'bw'"
                          style="display: none">
                          <span data-ko-display="fbVisible" data-ko-wrap="false">&nbsp;</span>
                          <a data-ko-display="fbVisible" href="" style="-ko-attr-href: @fbUrl">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/facebook_bw_ok.png" alt="Facebook" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="twVisible" data-ko-wrap="false">&nbsp;</span>
                          <a data-ko-display="twVisible" href="" style="-ko-attr-href: @twUrl">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/twitter_bw_ok.png" alt="Twitter" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="ggVisible" data-ko-wrap="false">&nbsp;</span>
                          <a data-ko-display="ggVisible" href="" style="-ko-attr-href: @ggUrl">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/google+_bw_ok.png" alt="Google+" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="webVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="webVisible" href="" style="-ko-attr-href: @webUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/web_bw_ok.png" alt="Web" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="inVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="inVisible" href="" style="-ko-attr-href: @inUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/linkedin_bw_ok.png" alt="Linkedin" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="flVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="flVisible" href="" style="-ko-attr-href: @flUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/flickr_bw_ok.png" alt="Flickr" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="viVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="viVisible" href="" style="-ko-attr-href: @viUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/vimeo_bw_ok.png" alt="Vimeo" border="0" class="socialIcon" />
                          </a>
                          <span data-ko-display="instVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="instVisible" href="" style="-ko-attr-href: @instUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/instagram_bw_ok.png" alt="Instagram" border="0"  class="socialIcon" />
                          </a>
                          <span data-ko-display="youVisible" data-ko-wrap="false" style="display: none">&nbsp;</span>
                          <a data-ko-display="youVisible" href="" style="-ko-attr-href: @youUrl; display: none">
                            <img src="<?php echo base_url(); ?>public/emailbuilder/versatile/img/social_def/youtube_bw_ok.png" alt="Youtube" border="0" class="socialIcon" />
                          </a>
                        </td>
                      </tr>
                    </table>

</div>
<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]-->
<!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]-->

            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /socialBlock -->

  </div>

  <!-- footerBlock -->
  <table width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#3f3f3f"
    style="background-color: #3f3f3f; -ko-background-color: @backgroundColor; -ko-attr-bgcolor: @backgroundColor"  data-ko-block="footerBlock">
    <tr>
      <td align="center" valign="top" bgcolor="#3f3f3f" style="background-color: #3f3f3f;
        -ko-attr-bgcolor: @backgroundColor; -ko-background-color: @backgroundColor">

<!--[if (gte mso 9)|(lte ie 8)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="570"><tr><td align="center" valign="top"><![endif]-->
        <div class="oldwebkit">
        <table width="570" style="width: 100%; max-width: 570px" border="0" cellpadding="0" cellspacing="9" class="vb-container halfpad" align="center">
          <tr>
            <td data-ko-editable="longText" class="long-text links-color"
                style="text-align:center; font-size: 13px;color: #919191; font-weight: normal; text-align:center; font-family: Arial, Helvetica, sans-serif;
                -ko-font-size: @[longTextStyle.size]px; -ko-color: @longTextStyle.color; -ko-font-family: @longTextStyle.face"><p>Email sent to <a href="mailto:[mail]">[mail]</a></p></td>
          </tr>
          <tr>
            <td style="text-align: center;">
              <a style="text-decoration: underline; color: #ffffff; text-align: center; font-size: 13px;
                font-weight: normal; font-family: Arial, Helvetica, sans-serif;
                -ko-text-decoration: @linkStyle.decoration; -ko-font-size: @[linkStyle.size]px; -ko-font-family: @linkStyle.face"
                href="[unsubscribe_link]"><span data-ko-editable="disiscrivitiText">Unsubscribe</span></a>
            </td>
          </tr>
        </table>
        </div>
<!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
      </td>
    </tr>
  </table>
  <!-- /footerBlock -->

  </center>
</body>
</html>