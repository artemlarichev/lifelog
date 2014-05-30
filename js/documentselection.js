/*
*  $Id: documentselection.js 304 2007-07-30 11:04:17Z wingedfox $
*  $HeadURL: https://svn.debugger.ru/repos/jslibs/BrowserExtensions/trunk/documentselection.js $
*
*  Class implements cross-browser work with text selection
*
*  @author Ilya Lebedev
*  @author $Author: wingedfox $
*  @modified $Date: 2007-07-30 15:04:17 +0400 (Пнд, 30 Июл 2007) $
*  @version $Rev: 304 $
*  @license LGPL
*/
/*
*  @class DocumentSelection
*/
DocumentSelection = new function () {
  var self = this;
  /*
  *  Stores hash of keys, applied to elements
  *
  *  @type Object
  *  @scope private
  */
  var keys = {
    'selectionStart' : '__DSselectionStart'
   ,'selectionEnd' : '__DSselectionEnd'
  }
  /**
   *  Special document node, used to calculate range offsets in Mozilla
   *
   *  @type HtmlDivElement
   *  @scope private
   */
  var offsetCalculator = null;
  /**
   *  Keeps scrolling on the place for browsers, those don't support this natively
   *
   *  @param {HTMLElement} el target element
   *  @param {Number} ot old scrollTop property
   *  @param {Number} ol old scrollLeft property
   *  @scope private
   */
  var keepScroll = function (el,ot,ol) {
      if (window.getSelection && (!el.scrollLeft || !el.scrollTop)) {
          var q = self.getSelectionOffset(el)
          if (ot>q.y)                          el.scrollTop = q.y;
          else if (ot+el.offsetHeight<q.y+q.h) el.scrollTop = ot+q.h;
          else                                 el.scrollTop = ot; 
          if (ol>q.x)                          el.scrollLeft = q.x;
          else if (ol+el.offsetWidth<q.x+q.h) el.scrollLeft = ol+q.h;
          else                                 el.scrollLeft = ol; 
      }
  }
  //---------------------------------------------------------------------------
  //  SETTERS
  //---------------------------------------------------------------------------
  /**
   *  getSelectionRange wrapper/emulator
   *  adapted version
   *
   *  @see http://www.bazon.net/mishoo/articles.epl?art_id=1292
   *  @param {HTMLElement}
   *  @param {Number} start position
   *  @param {Number} end position
   *  @param {Boolean} related indicates calculation of range relatively to current start point
   *  @return void
   *  @scope public
   */
  self.setRange = function(el, start, end, related) {
    /*
    *  set range on relative coordinates
    */
    if (related) {
      var st = self.getStart(el);
      end = st+end;
      start = st+start;
    }
    if ('function' == typeof el.setSelectionRange) {
      /*
      *  for Mozilla
      */
      try {el.setSelectionRange(start, end)} catch (e) {}
    } else {
      /*
      *  for IE
      */
      var range;
      /*
      *  just try to create a range....
      */
      try {
        range = el.createTextRange();
      } catch(e) {
        try {
          range = document.body.createTextRange();
          range.moveToElementText(el);
        } catch(e) {
          range = false;
        }
      }
      // if cannot create range
      if (!range) return false;
      range.collapse(true);

      range.moveStart("character", start);
      range.moveEnd("character", end - start);
      range.select();
    }
    self.setCursorPosition(el,start,end);
  }
  /**
   *  Set sursor position for supplied child
   *
   *  @param {HTMLElement} element to set cursor position on
   *  @param {Number} start selection start
   *  @param {Number} end selection end
   *  @scope public
   */
  self.setCursorPosition = function (el,start,end) {
    el[keys.selectionStart] = parseInt(start);
    el[keys.selectionEnd] = parseInt(end);
  }
  //---------------------------------------------------------------------------
  //  GETTERS
  //---------------------------------------------------------------------------
  /**
   *  Return contents of the current selection
   *
   *  @param {HTMLElement} el element to look position on
   *  @return {String}
   *  @scope public
   */
  self.getSelection = function(el) {
    var s = self.getCursorPosition(el),
        e = self.getEnd(el);
    /*
    *  w/o this check content might be duplicated on delete
    */
    if (e<s) e = s;
    /*
    *  check for IE, because Opera does use \r\n sequence, but calculate positions correctly
    */
    var tmp = document.selection&&!window.opera?el.value.replace(/\r/g,""):el.value;
    return tmp.substring(s,e);
  }
  /**
   *  getSelectionStart wrapper/emulator
   *  adapted version
   *
   *  @see http://www.bazon.net/mishoo/articles.epl?art_id=1292
   *  @param {HTMLElement} el element to calculate end position for
   *  @param {HTMLElement} force force calculation
   *  @return {Number} start position
   *  @scope public
   */
  self.getStart = function (el, force) {
    var start;
    /*
    *  for IE
    */
    try {
      start = Math.abs(document.selection.createRange().moveStart("character", -100000000)); // start
      if (start>0 || force) {
        try {
          var endReal = Math.abs(el.createTextRange().moveEnd("character", -100000000));
          /*
          *  calculate node offset
          */
          var r = document.body.createTextRange();
          r.moveToElementText(el);
          var sTest = Math.abs(r.moveStart("character", -100000000));
          var eTest = Math.abs(r.moveEnd("character", -100000000));
          /*
          *  test for the TEXTAREA's dumb behavior
          */
          if (el.tagName.toLowerCase() != 'input' && eTest - endReal == sTest) {
            start -= sTest;
          }
        } catch(err) {}
      }
    } catch (e) {}
    /*
    *  for Mozilla/Opera/Safari
    */
    if (isNaN(start)) try { start = el.selectionStart } catch (e) { start = -1 }
    return start<1?(start==0&&force?0:(parseInt(el[keys.selectionStart])?parseInt(el[keys.selectionStart]):0)):start;
  }
  /*
  *  getSelectionEnd wrapper/emulator
  *  adapted version
  *
  *  @see http://www.bazon.net/mishoo/articles.epl?art_id=1292
  *  @param {HTMLElement} el element to calculate end position for
  *  @param {HTMLElement} force force calculation
  *  @return {Number} start position
  *  @scope public
  */
  self.getEnd = function (el,force) {
    var end;
    /*
    *  for IE
    */
    try {
      end = Math.abs(document.selection.createRange().moveEnd("character", -100000000)); // end
      if (end>0 || force) {
        try {
          var endReal = Math.abs(el.createTextRange().moveEnd("character", -100000000));
          /*
          *  calculate node offset
          */
          var r = document.body.createTextRange();
          r.moveToElementText(el);
          var sTest = Math.abs(r.moveStart("character", -100000000));
          var eTest = Math.abs(r.moveEnd("character", -100000000));
          /*
          *  test for the TEXTAREA's dumb behavior
          */
          if (el.tagName.toLowerCase() != 'input' && eTest - endReal == sTest) {
            end -= sTest;
          }
        } catch(err) {}
      }
    } catch (e) {}
    /*
    *  for Mozilla/Opera/Safari
    */
    if (isNaN(end)) try { end = el.selectionEnd } catch (e) { end = -1 }
    return end<1?(end==0&&force?0:(parseInt(el[keys.selectionEnd])?parseInt(el[keys.selectionEnd]):0)):end;
  }
  /*
  *  Return cursor position for supplied field
  *
  *  @param {HTMLElement} element to get cursor position from
  *  @return {Number} position
  *  @scope public
  */
  self.getCursorPosition = function (el) {
    return self.getStart(el);
  }
  //---------------------------------------------------------------------------
  //  MICS FUNCTIONS
  //---------------------------------------------------------------------------
  /*
  *  Used to save cursor position on click.
  *
  *  @param {MouseEvent} click event
  *  @scope protected
  */
  self.saveCursorPosition = function (e) {
    var el = e.srcElement||e.target;
    if (!el || !el.tagName) return false;
    var t = el.tagName.toLowerCase();
    if (t == 'textarea' || (t == 'input' && el.type == 'text')) {
        if ('undefined' == typeof el[keys.selectionStart]) el[keys.selectionStart] = -1;
        if ('undefined' == typeof el[keys.selectionEnd]) el[keys.selectionEnd] = -1;
        self.setCursorPosition(el,self.getStart(el,true),self.getEnd(el,true));
    }
  }
  /*
  *  Insert text at cursor position
  *
  *  @param {HTMLElement} text field to insert text
  *  @param {String} text to insert
  *  @scope public
  */
  self.insertAtCursor = function (fld, val) {
    var r = self.getCursorPosition(fld)
       ,ot = fld.scrollTop
       ,ol = fld.scrollLeft
    /*
    *  check for IE, because Opera does use \r\n sequence, but calculate positions correctly
    */
       ,tmp = document.selection&&!window.opera?fld.value.replace(/\r/g,""):fld.value;
    fld.value = tmp.substring(0, r)+val+tmp.substring(r,tmp.length);
    self.setRange(fld,r+val.length,r+val.length);
    keepScroll(fld,ot,ol);
  }
  /*
  *  Wraps selection with start and end text
  *
  *  @param {HTMLElement} text field to insert text
  *  @param {String} start text at the beginnging of the selection
  *  @param {String} end text at the end of the selection
  *  @scope public
  */
  self.wrapSelection = function (fld, start, end) {
    var s = self.getCursorPosition(fld)
       ,e = self.getEnd(fld)
    if (s==e) {
        self.insertAtCursor(fld,start+end);
    } else {
        self.insertAtCursor(fld,start);
        self.setRange(fld,e+start.length,e+start.length);
        self.insertAtCursor(fld,end);
    }
  }

  /*
  *  Deletes char at cursor position
  *
  *  @param {HTMLElement} text field to delete text
  *  @param {Boolean} delete text before (backspace) or after (del) cursor
  *  @scope public
  */
  self.deleteAtCursor = function (fld, after) {
    if (!after) after = false;
    var r = self.getCursorPosition(fld)
       ,e = self.getEnd(fld)
       ,ot = fld.scrollTop
       ,ol = fld.scrollLeft
    /*
    *  w/o this check content might be duplicated on delete
    */
    if (e<r) e = r;
    if (r==e) {
      r=after?r:r-1<0?0:r-1;
      e=after?e+1:e;
    }
    /*
    *  check for IE, because Opera does use \r\n sequence, but calculate positions correctly
    */
    var tmp = document.selection&&!window.opera?fld.value.replace(/\r/g,""):fld.value
       ,ret = tmp.substring(r+1,e-1);
    fld.value = tmp.substring(0, r)+tmp.substring(e,tmp.length);
    self.setRange(fld, r, r);
    keepScroll(fld,ot,ol)
    return ret;
  }
  /**
   *  Removes the selection, if available
   * 
   *  @param {HTMLElement} fld field to delete text from
   *  @scope public
   */
  self.deleteSelection = function (fld) {
    var s = self.getCursorPosition(fld)
       ,e = self.getEnd(fld)
       ,ot = fld.scrollTop
       ,ol = fld.scrollLeft
    if (s==e) return "";
    /*
    *  check for IE, because Opera does use \r\n sequence, but calculate positions correctly
    */
    var tmp = document.selection&&!window.opera?fld.value.replace(/\r/g,""):fld.value
       ,ret = tmp.substring(s,e);
    fld.value = tmp.substring(0, s)+tmp.substring(e,tmp.length);
    self.setRange(fld, s, s);
    keepScroll(fld,ot,ol)
    return ret;
  }
  /**
   *  Method is used to caclulate pixel offsets for the selection in TextArea (other inputs are not tested yet)
   *
   *  @param {HTMLTextareaElement} el target to calculate offsets
   *  @return {Object} {x: horizontal offset, y: vertical offset, h: height offset}
   *  @scope public
   */
  self.getSelectionOffset = function (el) {
      var range;
      if ('function' == typeof el.setSelectionRange) {
          /*
          *  For Mozilla
          */
          if (!offsetCalculator) {
              /*
              *  create hidden div, which will 'emulate' the textarea
              *  it's put 'below the ground', because toggling block/none is too expensive
              */
              offsetCalculator = document.createElement('td');

              document.body.appendChild(offsetCalculator);
          }
          /*
          *  store the reference to last-checked object, to prevent recalculation of styles
          */
          if (offsetCalculator[keys.prevCalcNode] != el) {
              offsetCalculator[keys.prevCalcNode] = el;
              var cs = document.defaultView.getComputedStyle(el, null);
              for (var i in cs) {
                  try {if (cs[i]) offsetCalculator.style[i] = cs[i];}catch(e){}
              }
              offsetCalculator.style.overflow = 'auto';
              offsetCalculator.style.position = 'absolute';
              offsetCalculator.style.visibility = 'hidden';
              offsetCalculator.style.zIndex = '-10';
              offsetCalculator.style.left="-10000px";
              offsetCalculator.style.top="-10000px";
              offsetCalculator.style.backgroundColor = 'yellow';

          }
          /*
          *  caclulate offsets to target and move div right below it
          */
          var range = document.createRange()
             ,val = el.value || " ";

          if ('input'==el.tagName.toLowerCase()) {
              offsetCalculator.style.width = 'auto'
              offsetCalculator.style.whiteSpace =  'nowrap';
          } else {
              offsetCalculator.style.whiteSpace = 'off'==el.getAttribute('wrap')?"pre":"";
          }
          
          val = val.replace(/\x20\x20/g,"\x20\xa0")
          offsetCalculator.innerHTML = ( val.substr(0,el.selectionStart)+"<span></span>"
                                        +val.substr(el.selectionStart)).replace(/\n/g,"<br />")
                                                                       .replace(/\t/g,"<em style=\"white-space:pre\">\t</em>")
          /*
          *  span is used to find the offsets
          */
          var span = offsetCalculator.getElementsByTagName('span')[0];
          span.style.borderLeft = '1px solid red';
          range.offsetLeft = span.offsetLeft - el.scrollLeft;
          range.offsetTop = span.offsetTop - el.scrollTop;
          range.offsetHeight = span.offsetHeight;
          span = null;
          /*
          *  this is required, because Mozilla sometimes looses visual cursor, if div is not hidden
          */
      } else if (document.selection && document.selection.createRange) {
          /*
          *  For IE
          */
          range = document.selection.createRange();
          /*
          *  IE does not allow to calculate lineHeight, but this check is easy
          */
          range.offsetHeight = Math.round(range.boundingHeight/(range.text.replace(/[^\n]/g,"").length+1));
          if (el.tagName && 'textarea'==el.tagName.toLowerCase()) {
              var xy = DOM.getOffset(el)
              range = {
                  'offsetTop' : range.offsetTop-xy.y
                 ,'offsetLeft' : range.offsetLeft-xy.x
                 ,'offsetHeight' : range.offsetHeight
              }
          }
      }
      if (range) {
          return {'x': range.offsetLeft, 'y': range.offsetTop, 'h': range.offsetHeight};
      }
      return {'x': 0, 'y': 0, 'h': 0};
  }

}
/*
*  Add cursor position saving
*/
if (document.attachEvent) {
  document.attachEvent('onmouseup', DocumentSelection.saveCursorPosition);
  document.attachEvent('onkeyup', DocumentSelection.saveCursorPosition);
} else if (document.addEventListener) {
  document.addEventListener('mouseup', DocumentSelection.saveCursorPosition,false);
  document.addEventListener('keyup', DocumentSelection.saveCursorPosition,false);
}
