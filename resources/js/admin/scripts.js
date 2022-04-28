var slug = require('slug')
const htmlToImage = require("html-to-image");
var $ic = 1;

function toLatin(str) {
    const ru = {
        'а': 'a',
        'б': 'b',
        'в': 'v',
        'г': 'g',
        'д': 'd',
        'е': 'e',
        'ё': 'e',
        'ж': 'j',
        'з': 'z',
        'и': 'i',
        'ї': 'e',
        'к': 'k',
        'л': 'l',
        'м': 'm',
        'н': 'n',
        'о': 'o',
        'п': 'p',
        'р': 'r',
        'с': 's',
        'т': 't',
        'у': 'u',
        'ф': 'f',
        'х': 'h',
        'ц': 'c',
        'ч': 'ch',
        'ш': 'sh',
        'щ': 'shch',
        'ы': 'y',
        'э': 'e',
        'ю': 'u',
        'я': 'ya'
    }, n_str = []

    str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i')

    for (let i = 0; i < str.length; ++i) {
        n_str.push(
            ru[str[i]]
            || ru[str[i].toLowerCase()] === undefined && str[i]
            || ru[str[i].toLowerCase()].replace(/^(.)/, function (match) {
                return match.toUpperCase()
            })
        )
    }
    return n_str.join('').replace(/ /gi, '_')
}

$(document).ready(function () {

    window._token = $('meta[name="csrf-token"]').attr('content')

    moment.updateLocale('en', {
        week: {dow: 1} // Monday is the first day of the week
    })

    $('.date').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'en'
    })

    $(".tab-content").on("click", ".slug-generate", function () {
        return $("#slug").val(slug(($(".name_en").length)?$(".name_en").val():$(".name_uk").val()))
    })
    $("td.slug").on("click", ".slug-generate-attribute", function () {
        var id = $(this).data('name')
        var title = $(".name_us_"+id)
        var slug_input = $(".slug_"+id)
        return slug_input.val(slug(title.length ? title.val() : ''))
    })
    $(document).on('click','.slug-generate-attribute-new ', function () {
        var id = $(this).data('name');
        var title = $(".name_new_us_" + id);
        var slug_input = $(".slug_new_" + id);
        console.log(title)
        return slug_input.val(slug(title.length ? title.val() : ''));
    })
    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: 'en',
        sideBySide: true
    })

    $('.timepicker').datetimepicker({
        format: 'HH:mm:ss'
    })

    $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
    })
    $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
    })

    $('.select2').select2()

    $('.treeview').each(function () {
        var shouldExpand = false
        $(this).find('li').each(function () {
            if ($(this).hasClass('active')) {
                shouldExpand = true
            }
        })
        if (shouldExpand) {
            $(this).addClass('active')
        }
    })


    $(document).on("click", ".browse", function () {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    /*$('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });*/

    $(document).on('click', '.btn btn-success', function () {
        $(".alert").delay(1).fadeOut("slow", function () {
            console.log(1);
            $(this).remove();
        })
    })

    $('.with-loading').on("click", function () {
        if (!$(this).find('loading').length) {
            new Loading($(this));
        }
        return setTimeout(() => {
            var $form;
            $form = $(this).closest('form');
            if ($form.length) {
                return $form.submit();
            }
        }, 200);
    });

    $(document).ready(function () {
        $('.toogle').bootstrapToggle();
    });

    /*const $urlElem = $('input[name="ru[title]"]');
    console.log($urlElem);
    if ($urlElem.length) {
        const slugElem = $('input[name="slug"]')
        $urlElem.on('input', e => {
            const value = $(e.delegateTarget).val();
            slugElem.val(toLatin(value))
        })

    }*/
})

Loading = class Loading {
    constructor(obj) {
        var $loader, position;
        this.obj = obj;
        $loader = $('<div id="loader" class="loading"><i class="fa fa-cog fa-spin" aria-hidden="true"></i></div>').appendTo(this.obj);
        position = this.obj.css('position');
        if (position !== 'absolute' && position !== 'fixed' && position !== 'relative') {
            this.obj.css('position', 'relative');
        }
    }

    hide() {
        return this.obj.find('.loading').remove();
    }

};


function initTableNews() {
    if (document.getElementById('datatable1')) {
        $(document).ajaxComplete(function () {
            $('.ajax_ckeckbox').bootstrapToggle()
        });
        $(document).on('change', '.ajax_ckeckbox', function (event) {
            const field = $(this).data('field');
            const id = $(this).data('id');
            const _token = $(this).data('token');
            const value = ($(this).is(':checked')) ? 1 : 0;
            const url = $(this).data('url');
            $.ajax({
                type: "POST",
                url: url,
                data: {_token: _token, id: id, field: field, value: value},
                success: function (result) {
                    toastr.success("Статус Успешно обновлен", "Succsess");
                    console.log('succsess')
                },
                error: function (result) {
                    toastr.error("Ошибка", "Error");
                    console.log('error')
                },
            });
        });
    }
}

initTableNews();

$(document).ready(function () {

    $('#input_image').on('change',function ()
    {
        var div = $('#upload_div')

        if(!div.find('#delete_js_image').length && !div.find('#delete_image').length) {

            var img = div.children('img')

            var create_label = $(document.createElement('label'))

            create_label.attr('style', 'color: red; display: block; margin-left: 10px;')

            create_label.attr('id', 'delete_js_image')

            create_label.text('X')

            var label = img.before(create_label)
        }
    })

    $(document).on('click','#delete_js_image',function ()
    {
        $(this).remove()
        $('#input_image').val('')
        $('#img').attr('src',window.location.origin + '/storage/images/upload_image.png')
    })

    $('#delete_image').on('click',function ()
        {
            var _token = $(this).data('token');
            var field = $(this).data('field');
            var id = $(this).data('id');
            var url = $(this).data('url');
            var value = '';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: _token,
                    id: id,
                    field: field,
                    value: value
                },
                success: function success(result) {
                    toastr.success("Картинка успешно удалена", "Succsess");
                    $('#delete_image').next().attr('src',window.location.origin + '/storage/images/upload_image.png');
                    $('#delete_image').remove();
                },
                error: function error(result) {
                    toastr.error("Ошибка", "Error");
                    console.log('error');
                }
            })
        }
    )

    $(".duplicat").each(function () {
        return duplicate_row($(this))
    })/*, $("body").on("click", "table.duplication .create", function() {
            duplicate_row($(this))
        })*/, $("body").on("click", "table.duplication .destroy", function () {
        var t;
        return t = $(this), $(this).closest(".duplication_row").fadeOut(function () {
            return $("table.duplication .create").length < 3 && duplicate_row(t), $(this).remove()
        })
    }), $("body").on("click", "table.duplication .destroy.exists", function () {
        var t, e, a;
        return t = $(this), e = t.data("id"), e && (a = $(this).data("name"), $(this).closest("form").append('<input type="hidden" name="' + a + '" value="' + e + '" />')), $(this).closest(".duplication_row").fadeOut(function () {
            return $("table.duplication .create").length < 3 && duplicate_row(t), $(this).remove()
        })
    }), $(document).on("click", ".duplication .destroy", function() {
            var $th = $(this)
            var $parentRow = $th.parents('tr');
            var index = $parentRow.index();

            var $parentElem = $th.parents('.parent-elem');
            var $childrenTabs = $parentElem.find('.tab-pane')
            if($childrenTabs.length === 0){
                $childrenTabs = $parentElem.find('.no-children__tabs')
            }
            $childrenTabs.each((t, elem) => {
                var $el = $(elem);
                var $trs = $el.find('tr')
                $trs.each((i, e) => {
                    if(i === index){
                        $(e).remove()
                    }
                })
            })
        });
});


$(document).ready(function() {
    window.ic = $('.duplication-row').length;
    $(".duplication.duplicate-on-start").each(function() {
        return duplicate_row($(this));
    });
    $(document).on("click", ".duplication .create", function() {
        return duplicate_row($(this));
    });

    $(document).on("click", ".duplication .destroy", function() {
        var $th = $(this)
        var $parentRow = $th.parents('tr');
        var index = $parentRow.index();

        var $parentElem = $th.parents('.parent-elem');
        var $childrenTabs = $parentElem.find('.tab-pane')
        if($childrenTabs.length === 0){
            $childrenTabs = $parentElem.find('.no-children__tabs')
        }
        $childrenTabs.each((t, elem) => {
            var $el = $(elem);
            var $trs = $el.find('tr')
            $trs.each((i, e) => {
                if(i === index){
                    $(e).remove()
                }
            })
        })
    });
});


window.duplicate_row = function (t) {
    var e, a;
    a = t.closest(".duplication");
    console.log(a.find(".duplicat"), a.find(".duplicat").length);
    if (a.find(".duplicat").length > 0) {
        duplicate_row_old(t);
    } else {
        duplicate_row_new(t);
    }

}

window.duplicate_row_old = function (t) {
    var e, a;
    t.hasClass("table.duplication") || (a = t.closest(".duplication")), e = a.find(".duplicat").clone(!0), 0 !== e.length && ($ic++, e[0].innerHTML = e[0].innerHTML.replace(/replaseme/g, $ic), e.find("div.select-2").remove(), e.removeClass("duplicat"),e.removeClass("hidden"), e.addClass("duplic").insertBefore(a.find(".duplication_row.duplicat")))
};

window.duplicate_row_new = function (t) {
    var e, a;
    return a = t.hasClass("duplication") ? t : t.closest(".duplication"),
        e = a.find(".duplicate").clone(!0),
        0 !== e.length ? (window.ic++, e[0].innerHTML = e[0].innerHTML.replace(/replaseme/g, window.ic),
            e.removeClass("duplicate").insertBefore(a.find(".duplication-button")),
            e.find(".form-control").each(function () {
                return $(this).attr("name", $(this).data("name")),
                    $(this).data("required") ? $(this).attr("required", $(this).data("required")) : void 0
            }), !0) : void 0
};

$(document).ready(function () {
    var $invalidValidationElems = $('.is-invalid');

    if ($invalidValidationElems.length) {
        $invalidValidationElems.each((index, elem) => {
            const $el = $(elem);
            var id = $el.parents('.parent-elem').attr('id')
            var $tabs = $('.card-body>.nav-tabs>.nav-item>a');
            $tabs.each((i, e) => {
                const $el = $(e);
                const href = $el.attr('href').replace('#', '')
                if (id === href) {
                    $el.addClass('error')
                }
            })
        })
    }
})

$(document).on('change', '.input-file', function (e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);
    let inputElement = $(this)
    let parentSection = $(this).parent('div')
    let imageElement = parentSection.find('img')

    var reader = new FileReader();
    reader.onload = function (e) {

        imageElement.attr("src", e.target.result);
    };

    reader.readAsDataURL(this.files[0]);
});

//CKEDITOR
$(document).ready(function () {
    CKEDITOR.config.removePlugins = 'elementspath';
    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_P;
});

$(document).on('click', ".upload-button-image", function (){

    let url = '/file-manager/fm-button?attr-id=' + $(this).attr('data-tr-id')
    let locale = $(this).attr('data-locale')

    if (locale) {
        url += '&locale=' + locale
    }

    window.open(url, 'fm', 'width=1000,height=600').focus();
})

function fmSetLink($url, dataId, dataLocale) {
    let imgClass = '.upload-preview-img'
    let btnClass = '.upload-label-img'

    if (dataId){
        imgClass += '-' + dataId
        btnClass += '-' + dataId
    }

    if (dataLocale) {
        imgClass += '-' + dataLocale
        btnClass += '-' + dataLocale
    }

    $(imgClass).parents('.image-wrap').find('.removeFile').attr('hidden', false)
    $(imgClass).parents('.image-wrap').find('.showFile').attr('hidden', false)
    $(imgClass).parents('.image-wrap').find('.showFile').attr('href', $url)

    $(imgClass).attr('hidden', false)
    $(imgClass).attr('src', $url)
    $(btnClass).val($url)
}

window.fmSetLink = fmSetLink;

$(document).on('input', '.preview-link', function () {
    $(this).parents('.image-wrap').find('.preview').attr('hidden', false)
    $(this).parents('.image-wrap').find('.preview').attr('src', $(this).val())
})

$(document).on('click', '.removeFile', function () {
    let wrap = $(this).parents('.image-wrap')

    wrap.find('.isRemoveFile').val('1');
    wrap.find('.preview').attr('src', wrap.attr('data-default'));
    wrap.find('.input-file').val('');
    wrap.find(".removeFile").attr('hidden', true);
    wrap.find(".showFile").attr('hidden', true);
    wrap.find(".preview-link").val('');
    wrap.find('.file_preview').attr('hidden', true);
})

$(document).on('change', '.contact-position', function () {
    value = $(this).val()
    input_name =  $(this).attr('name')

    $(`input[name='${input_name}']`).each(function () {
        $(this).val(value)
    })
})

$(document).on('change', '.contact-status', function () {
    value = $(this).val()

    input_name =  $(this).attr('name')

    $(`select[name='${input_name}']`).each(function () {
        $(this).val(value)
    })
})
