__NUXT_JSONP__("/database/scopes", (function(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W){return {data:[{document:{slug:"scopes",title:A,category:K,toc:[{id:L,depth:2,text:M}],body:{type:"root",children:[{type:b,tag:p,props:{},children:[{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"Place all scopes in your domain in "},{type:b,tag:h,props:{},children:[{type:a,value:"Models\\Scopes"}]},{type:a,value:" namespace and always use "},{type:b,tag:h,props:{},children:[{type:a,value:N}]},{type:a,value:" suffix."}]},{type:a,value:f}]},{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"✓ Extend "},{type:b,tag:h,props:{},children:[{type:a,value:"AbstractScope"}]},{type:a,value:" instead of "},{type:b,tag:h,props:{},children:[{type:a,value:N}]},{type:a,value:" interface"}]},{type:a,value:f},{type:b,tag:"h2",props:{id:L},children:[{type:b,tag:"a",props:{ariaHidden:O,href:"#relation-scope",tabIndex:-1},children:[{type:b,tag:c,props:{className:["icon","icon-link"]},children:[]}]},{type:a,value:M}]},{type:a,value:f},{type:b,tag:p,props:{},children:[{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"Name your scope "},{type:b,tag:h,props:{},children:[{type:a,value:"With{RelationName}Scope"}]},{type:a,value:" and extend AbstractNestedRelationScope. Place the scope where the \"relation\"\nmodel lives."}]},{type:a,value:f}]},{type:a,value:f},{type:b,tag:j,props:{},children:[{type:b,tag:h,props:{},children:[{type:a,value:B}]},{type:a,value:" helps you to make reusable relation scopes with ability to apply scopes on the\nrelation. "},{type:b,tag:C,props:{},children:[{type:a,value:"Allows you to load a relation and select specified columns, load more relations and others using scope\nchaining"}]},{type:a,value:"."}]},{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"The scope works in 2 modes:"}]},{type:a,value:f},{type:b,tag:"ul",props:{},children:[{type:a,value:f},{type:b,tag:P,props:{},children:[{type:b,tag:C,props:{},children:[{type:a,value:"(default)"}]},{type:a,value:" loads the relation (uses "},{type:b,tag:h,props:{},children:[{type:a,value:"with"}]},{type:a,value:k}]},{type:a,value:f},{type:b,tag:P,props:{},children:[{type:b,tag:C,props:{},children:[{type:a,value:"(pass "},{type:b,tag:h,props:{},children:[{type:a,value:"useHas: true"}]},{type:a,value:" constructor parameter)"}]},{type:a,value:" filters by the relation (uses "},{type:b,tag:h,props:{},children:[{type:a,value:"whereHas"}]},{type:a,value:k}]},{type:a,value:f}]},{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"Create a scope that can be used with a model that has "},{type:b,tag:h,props:{},children:[{type:a,value:"type"}]},{type:a,value:" relation in the model."}]},{type:a,value:f},{type:b,tag:D,props:{className:[E]},children:[{type:b,tag:F,props:{className:[q,G]},children:[{type:b,tag:h,props:{},children:[{type:b,tag:c,props:{className:[d,"php",q]},children:[{type:b,tag:c,props:{className:[d,"delimiter","important"]},children:[{type:a,value:"\u003C?php"}]},{type:a,value:r},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"declare"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:m}]},{type:a,value:"strict_types"},{type:b,tag:c,props:{className:[d,"operator"]},children:[{type:a,value:"="}]},{type:b,tag:c,props:{className:[d,"number"]},children:[{type:a,value:"1"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:k}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:s}]},{type:a,value:r},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"namespace"}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,Q]},children:[{type:a,value:"App"},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:n}]},{type:a,value:"Object"},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:n}]},{type:a,value:R},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:n}]},{type:a,value:A}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:s}]},{type:a,value:r},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"use"}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,Q]},children:[{type:a,value:"LaraStrict"},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:n}]},{type:a,value:K},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:n}]},{type:a,value:A},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:n}]},{type:a,value:B}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:s}]},{type:a,value:r},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"class"}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,"class-name-definition",t]},children:[{type:a,value:H}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"extends"}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,t]},children:[{type:a,value:B}]},{type:a,value:f},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:S}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"protected"}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:u}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,"function-definition",u]},children:[{type:a,value:"getRelationName"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:m}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:k}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:v}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,i,"return-type"]},children:[{type:a,value:w}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:S}]},{type:a,value:T},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:"return"}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,w,I]},children:[{type:a,value:"'object'"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:s}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:U}]},{type:a,value:f},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:U}]},{type:a,value:f}]}]}]}]},{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"Use the scope in your "},{type:b,tag:h,props:{},children:[{type:a,value:"Query"}]}]},{type:a,value:f},{type:b,tag:D,props:{className:[E]},children:[{type:b,tag:F,props:{className:[q,G]},children:[{type:b,tag:h,props:{},children:[{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:x}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,u]},children:[{type:a,value:H}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:m}]},{type:b,tag:c,props:{className:[d,J]},children:[{type:a,value:V}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:v}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:y}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:x}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,t]},children:[{type:a,value:"SelectScope"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:m}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:y}]},{type:b,tag:c,props:{className:[d,w,I]},children:[{type:a,value:"'id'"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:o}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,w,I]},children:[{type:a,value:"'object_name'"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:z}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:k}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:o}]},{type:a,value:f},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:z}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:k}]},{type:a,value:f}]}]}]},{type:a,value:f},{type:b,tag:p,props:{},children:[{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"This example load "},{type:b,tag:h,props:{},children:[{type:a,value:"object"}]},{type:a,value:" relation and selects given attributes."}]},{type:a,value:f}]},{type:a,value:f},{type:b,tag:D,props:{className:[E]},children:[{type:b,tag:F,props:{className:[q,G]},children:[{type:b,tag:h,props:{},children:[{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:x}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,u]},children:[{type:a,value:H}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:m}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,J]},children:[{type:a,value:V}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:v}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:y}]},{type:a,value:T},{type:b,tag:c,props:{className:[d,i]},children:[{type:a,value:x}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,t]},children:[{type:a,value:"WhereProviderIds"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:m}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:y}]},{type:b,tag:c,props:{className:[d,"variable"]},children:[{type:a,value:"$providerId"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:z}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:k}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:o}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:z}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:o}]},{type:a,value:l},{type:b,tag:c,props:{className:[d,J]},children:[{type:a,value:"useHas"}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:v}]},{type:a,value:g},{type:b,tag:c,props:{className:[d,"constant","boolean"]},children:[{type:a,value:O}]},{type:a,value:f},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:k}]},{type:b,tag:c,props:{className:[d,e]},children:[{type:a,value:o}]},{type:a,value:f}]}]}]},{type:a,value:f},{type:b,tag:p,props:{},children:[{type:a,value:f},{type:b,tag:j,props:{},children:[{type:a,value:"This example filters entries by given object relation that has given provider_id attribute set to given value-"}]},{type:a,value:f}]}]},dir:"\u002Fen\u002Fdatabase",path:"\u002Fen\u002Fdatabase\u002Fscopes",extension:".md",createdAt:W,updatedAt:W,to:"\u002Fdatabase\u002Fscopes"},prev:{title:R,path:"\u002Fen\u002Fdatabase\u002Fmodels",to:"\u002Fdatabase\u002Fmodels"},next:null}],fetch:{},mutations:[]}}("text","element","span","token","punctuation","\n"," ","code","keyword","p",")","\n    ","(","\\",",","blockquote","language-php","\n\n",";","class-name","function",":","string","new","[","]","Scopes","AbstractNestedRelationScope","em","div","nuxt-content-highlight","pre","line-numbers","WithObjectScope","single-quoted-string","argument-name","Database","relation-scope","Relation scope","Scope","true","li","package","Models","{","\n        ","}","relationScopes","2024-02-28T16:40:16.824Z")));