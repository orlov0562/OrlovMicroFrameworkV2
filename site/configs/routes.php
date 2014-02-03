<?php

    return array(
        new Router('~^/?$~', 'Hello'),

        new Router(
            new RouterRegexp('/news[/@id]', TRUE, array(
                'id'=>'\d+',
            )),
            'Hello::Test'
        ),

        new Router('~^/index2$~', 'Hello::Index2'),

        new Router('~.*~', 'Hello::404'),
    );

/*

 проблема, не можем прописывать такие роутеры

 /@controller/@action/@id

чтоб вызывать так:
 @controller::@action($id)

*/