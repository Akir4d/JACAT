$(function(){
	$( 'textarea.texteditor' ).ckeditor({toolbar:'Full',startupMode: 'source',  width: '100%'});
	$( 'textarea.mini-texteditor' ).ckeditor({toolbarGroups: [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	],
	startupMode: 'source',
	removeButtons: 'Flash,Table,HorizontalRule,Language,Save,NewPage,Print,Templates,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Preview,PasteFromWord,PasteText,Paste,Iframe,Image,CreateDiv,Anchor,Undo,Redo,SelectAll,Replace,Find,SpecialChar,PageBreak,CopyFormatting,About,Font,ShowBlocks,BidiRtl,BidiLtr,Superscript,Subscript,Format,Styles,Unlink,Link'
	,width: '100%'});
});


