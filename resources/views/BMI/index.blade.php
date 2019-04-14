@extends('layouts.base')

@section('content')
    <div class="container fixed-top bg-white">
        <div class="row">
            <div class="col-6 d-flex justify-content-start">
                <img src="/images/girl_22.png" class="rounded girl girl-22" alt="22">
            </div>
            <div class="col-6 d-flex justify-content-end">
                <img src="/images/girl_33.png" class="rounded girl girl-33" alt="33">
            </div>
        </div>
    </div>

    {{--<div class="container text-center">
        <img src="https://q2.qlogo.cn/headimg_dl?dst_uin=593198779&spec=100" alt="查价喵" class="rounded-circle mt-5"
             id="qq-avatar">
    </div>--}}
    <div class="container" style="margin-top: 92px;">
        <!-- 提示 -->
        <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
            <i class="icon ion-md-information-circle-outline mr-2"></i>
            输入身高与体重，点击<strong>开始计算</strong>即可计算身体质量指数，请放心，应该没我胖。
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- end 提示 -->

        <label for="h" class="mt-3">
            <span class="badge badge-primary">性别</span>
        </label>
        <div class="input-group">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="sex1" name="sex" class="custom-control-input" value="1">
                <label class="custom-control-label" for="sex1">男</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="sex2" name="sex" class="custom-control-input" value="0">
                <label class="custom-control-label" for="sex2">女</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="sex3" name="sex" class="custom-control-input" value="2">
                <label class="custom-control-label" for="sex3">保密</label>
            </div>
        </div>

        <label for="h" class="mt-2">
            <span class="badge badge-primary">身高</span><span class="badge badge-pill badge-secondary ml-1">CM</span>
        </label>
        <div class="input-group">
            <input type="number" class="form-control" placeholder="你的身高" aria-describedby="h-button-add" id="h">
            <div class="input-group-append">
                <button class="btn btn-outline-danger clear" type="button" id="h-button-add">清空</button>
            </div>
        </div>

        <label for="w" class="mt-2">
            <span class="badge badge-primary">体重</span><span class="badge badge-pill badge-secondary ml-1">KG</span>
        </label>
        <div class="input-group">
            <input type="number" class="form-control" placeholder="你的体重" aria-describedby="h-button-add" id="w">
            <div class="input-group-append">
                <button class="btn btn-outline-danger clear" type="button" id="h-button-add">清空</button>
            </div>
        </div>

        <!-- 提交 -->
        <div class="d-flex justify-content-center">
            <div class="mt-2 py-4 px-5" id="loader" style="display: none; background-color: #7cd1f9; width: 100%">
                <div class="loader-inner pacman"></div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-primary btn-block mt-2" role="button" id="calcBmi">开始计算</button>
        <!-- end 提交 -->
    </div>

    <div class="container">
        <div class="pt-5">
            <span class="badge badge-pill badge-secondary">工具</span>
        </div>
        <div class="mt-2">
            <button class="btn-sm btn btn-primary" type="button" data-toggle="collapse"
                    data-target="#coll-principle"
                    aria-expanded="false" aria-controls="coll-principle">
                原理是什么
            </button>
            <button type="button" class="btn-sm btn btn-outline-danger ml-2" id="x">艺术家题字
            </button>
            <button type="button" class="btn-sm btn btn-primary ml-2" id="setAvatar">自定义QQ头像
            </button>
        </div>
        <div class="row">
            <div class="collapse" id="coll-principle">
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    世界卫生组织建议以身体质量指数（Body Mass Index,
                    BMI）来衡量肥胖程度，其计算公式是以<span class="badge badge-pill badge-danger">体重（公斤）除以身高（厘米）的平方</span>。
                    中国医院协会建议我国成人BMI应维持在18.5（kg/m2）及24（kg/m2）之间，太瘦、过重或太胖皆有碍健康。
                    研究显示，体重过重或是肥胖（BMI≧24）为糖尿病、心血管疾病、恶性肿瘤等慢性疾病的主要风险因素；而过瘦的健康问题，
                    则会有营养不良、骨质疏松、猝死等健康问题。
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            let sex = $("input[name='sex']");
            let h = $('#h');
            let w = $('#w');
            let clear = $('.clear');
            let loader = $('#loader');
            let x = $('#x');
            let setAvatar = $('#setAvatar');

            let girl22 = $('.girl-22');
            let girl33 = $('.girl-33');

            w.focus(function () {
                girl22.attr('src', '/images/girl_22_hide.png');
                girl33.attr('src', '/images/girl_33_hide.png');
            });
            w.blur(function () {
                girl22.attr('src', '/images/girl_22.png');
                girl33.attr('src', '/images/girl_33.png');
            });

            x.click(function () {
                swal({
                    title: '著名艺术家Lisa题字',
                    text: '我觉得很好看，你觉得呢',
                    icon: 'https://ws1.sinaimg.cn/large/a4d9cbc6gy1g21z9v35vyj20mp0ah4qp.jpg',
                    button: '你说的对',
                    closeOnClickOutside: false,
                })
            });

            setAvatar.click(function () {
                swal({
                    text: '在下方输入QQ号，检测结果画面的头像将使用你的QQ头像',
                    content: {
                        element: 'input',
                        attributes: {
                            placeholder: localdb.get('qq') ? localdb.get('qq') : 'QQ',
                            type: 'text',
                        }
                    },
                    buttons: {
                        cancel: '算了',
                        confirm: {
                            text: '写好了',
                            visible: true,
                            closeModal: false // 不关闭模态框
                        }
                    },
                    closeOnClickOutside: false,
                }).then((value) => {
                    if (value) {
                        let qq = `${value}`;
                        localdb.set('qq', qq);

                        swal.stopLoading();
                        swal.close();
                        swal({
                            icon: getQqAvatar(),
                            text: '设置成功',
                            buttons: false,
                            timer: 2000,
                        });
                    } else {
                        swal({
                            text: '你没有输入任何内容',
                            button: '哦',
                        });
                    }
                });
            });

            $('#calcBmi').click(function () {
                let hVal = h.val().replace(/\s/g, ''); // 去除空白字符
                let wVal = w.val().replace(/\s/g, '');
                if (hVal.length === 0) {
                    swal({
                        text: '你没有输入身高，我算不了',
                        button: '哦',
                    });
                    return false;
                }
                if (wVal.length === 0) {
                    swal({
                        text: '你没有输入体重，我算不了',
                        button: '哦',
                    });
                    return false;
                }

                var thisObj = $(this);
                thisObj.prop({disabled: true});
                thisObj.html('计算中');

                loader.is(':hidden') ? loader.slideDown('normal') : loader.slideUp('normal');

                let data = {
                    sex: $("input[name='sex']:checked").val(),
                    height: hVal,
                    weight: wVal,
                    qq: localdb.get('qq') ? localdb.get('qq') : ''
                };
                $.ajax({
                    url: '/api/bmi/calcBmi',
                    cache: false,
                    dataType: 'json',
                    data: data,
                    type: 'POST',
                    timeout: 4000,
                    success: function (rt, textStatus, jqXHR) {
                        thisObj.prop({disabled: false});
                        thisObj.html('开始计算');
                        if (rt.code === 0) {
                            let qqAvatarURL = getQqAvatar();
                            let content = document.createElement('div'); // js中创建的dom不会自动追加到文档中，不必担心影响样式。能取到dom值。
                            content.innerHTML = '<div class="container text-center">' +
                                '        <img src="' + (rt.imgURL !== '' ? rt.imgURL : qqAvatarURL) + '" alt="大头贴" class="rounded-circle mt-2">' +
                                '        <div class="row d-flex justify-content-center mt-4">' +
                                '            <div class="col-6 d-flex justify-content-end"><span class="mr-2 pt-2">检测结果</span></div>' +
                                '            <div class="col-6 d-flex justify-content-start">' + rt.bmi + '</div>' +
                                '        </div>' +
                                '        <div class="row d-flex justify-content-center mt-4">' +
                                '            <div class="col-6 d-flex justify-content-end"><span class="mr-2 pt-2">你的BMI</span></div>' +
                                '            <div class="col-6 d-flex justify-content-start">' + rt.bmiVal + '</div>' +
                                '        </div>' +
                                '        <div class="alert alert-warning mt-5" role="alert">' + rt.tips +
                                '        </div>' +
                                '    </div>';

                            swal({
                                content: content,
                                button: '哦',
                                closeOnClickOutside: false,
                            })
                        } else {
                            swal({
                                text: rt.msg,
                                button: '我知道了',
                            });
                        }

                        loader.is(':hidden') ? loader.slideDown('normal') : loader.slideUp('normal');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        thisObj.prop({disabled: false});
                        thisObj.html('开始计算');
                        if (textStatus === 'timeout') {
                            swal({
                                text: '服务器没有鸟你，别气馁，再点一下试试',
                                button: '哦',
                            });
                        } else {
                            swal({
                                text: errorThrown,
                                button: '哦',
                            });
                        }

                        loader.is(':hidden') ? loader.slideDown('normal') : loader.slideUp('normal');
                    }
                });
            });

            function getQqAvatar() {
                let qq = localdb.get('qq') && /^\d{5,}$/.test(localdb.get('qq')) ? localdb.get('qq') : '1435760195';

                return 'https://q2.qlogo.cn/headimg_dl?dst_uin=' + qq + '&spec=100';
            }

            clear.click(function () {
                let input = $(this).parent().siblings('input');
                input.val('');
                input.focus();
            });

            if (localdb.check()) {
                h.val(localdb.get('hVal') ? localdb.get('hVal') : '');
                w.val(localdb.get('wVal') ? localdb.get('wVal') : '');
                $("input[name='sex'][value='" + (localdb.get('sexVal') ? localdb.get('sexVal') : 2) + "']").attr('checked', true);

                // 监听输入事件
                h.bind('input porpertychange', function () {
                    localdb.set('hVal', h.val());
                });
                w.bind('input porpertychange', function () {
                    localdb.set('wVal', w.val());
                });

                sex.change(function () {
                    localdb.set('sexVal', $(this).val());
                });
            } else {
                swal('你的浏览器不支持localStorage，本地的输入不会被实时保存，请注意');
            }
        });
    </script>
@endpush