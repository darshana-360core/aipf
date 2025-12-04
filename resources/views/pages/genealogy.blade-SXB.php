@extends('layouts.app')

@section('title', 'Profile')

@section('style')
<link rel="stylesheet" href="{{asset('assets/css/listree.min.css')}}">

<style type="text/css">
    /*Three*/
    .tree_holder {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 30px;
        color: #ffffff;
    }

    .bstree {
        min-width: 900px;
    }

    .bstree,
    .bstree ul {
        list-style: none;
        position: relative;
    }

    .bstree-vline {
        position: absolute;
        border-left: 1px dashed #369dbd;
        bottom: 0;
        content: "";
        display: block;
        left: 16px;
        top: -25px;
        height: calc(100% + 8px);
    }

    .bstree-children li::before {
        position: absolute;
        height: 0;
        left: 18px;
        width: 25px;
        content: "";
        display: block;
        margin-top: 12px;
        border-top: 1px dashed #369dbd;
    }

    .bstree-children li {
        margin-left: 40px;
    }

    .bstree-incomplete>.checkbox label {
        text-decoration: underline;
    }

    .bstree-chevron {
        cursor: pointer;
    }

    .bstree input[type="checkbox"] {
        margin-top: 0.3rem;
    }

    .custom-checkbox .custom-control-indicator {
        margin-top: 2px;
    }

    .bstree-data .fa {
        vertical-align: 0;
    }

    .bstree-data .bstree-inner-container {
        margin-bottom: 6px;
    }

    .bstree-chevron {
        position: absolute;
        width: 100px;
        padding-left: 5px;
    }

    .bstree-label-container {
        margin-left: 23px;
    }

    /* #mytree ul li:nth-child(even) {
  background: #3C3E59;
} */

    /* #mytree ul li:nth-child(odd) {
  background: #32344E;
} */

    .tree_name_main {
        font-weight: 700;
        font-size: 14px;
        line-height: 1;
        padding-right: 20px;
    }

    .tree_name_main img {
        width: 45px;
        height: 45px;
        border-radius: 0%;
        margin-right: 10px;
        display: inline-block;
    }

    .tree_head {
        display: -ms-grid;
        display: grid;
        -ms-grid-columns: auto 110px 100px 90px 100px 100px 100px 100px 100px 100px 100px 100px;
        grid-template-columns: auto 110px 100px 90px 100px 100px 100px 100px 100px 100px 100px 100px;
        text-align: left;
        font-weight: 500;
        font-size: 14px;
        line-height: 24px;
    }

    .tree_head div {
        width: 100%;
        padding-left: 20px;
        line-height: 1;
    }

    .tree_head .tree_usd {
        padding-left: 0px;
        justify-content: flex-end;
        text-align: right;
    }

    .tree_name {
        padding-left: 50px;
        font-weight: 500;
        font-size: 14px;
        line-height: 1.2;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        cursor: pointer;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
    }

    .tree_head .tree_rang {
        justify-content: flex-start;
        padding-left: 0px;
    }

    .tree_head .tree_packages {
        text-align: left;
        justify-content: flex-start;
        padding-left: 20px;
        padding-right: 15px;
    }

    .tree_head .tree_rank {
        padding-left: 0px;
    }

    .tree_name img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        margin-right: 10px;
        /* border: 1px solid #898e8c; */
    }

    .tree_name:hover>.more_about_part {
        opacity: 1;
    }

    .more_about_part a:hover {
        opacity: 0.7;
    }

    .tree_part {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding-left: 20px;
        padding-right: 15px;
        line-height: 1.1;
    }

    .maintreebox {
        min-width: max-content;
    }

    .tree_rang {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        justify-content: flex-start;
    }

    .tree_usd {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    }

    .tree_part_line {
        display: -ms-grid;
        display: grid;
        -ms-grid-columns: auto 110px 100px 90px 100px 100px 100px 100px 100px 100px 100px 100px;
        grid-template-columns: auto 110px 100px 90px 100px 100px 100px 100px 100px 100px 100px 100px;
        text-align: left;
        margin-top: -33px;
    }

    .bstree-expanded,
    .bstree-closed,
    .bstree-node {
        padding: 25px 0px 0 0;
        font-size: 13px;
    }

    .tree_part_main_li .tree_plus_minus {
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        border: 1px solid #369dbd;
        box-sizing: border-box;
        border-radius: 30px;
        position: relative;
        z-index: 1;
        line-height: 1;
        align-items: center;
        font-size: 28px;
        font-weight: 600;
        margin-top: -6px;
        background-color: #ffffff;
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
    }

    .tree_part_li .tree_plus_minus {
        width: 24px;
        height: 24px;
        display: flex;
        justify-content: center;
        border: 1px solid #ffffff;
        box-sizing: border-box;
        border-radius: 4px;
        color: #ffffff;
        background: #2cb4ff;
        position: relative;
        z-index: 1;
        font-weight: 700;
        line-height: 1.3;
        align-items: center;
    }

    .tree_part_line_main {
        display: -ms-grid;
        display: grid;
        -ms-grid-columns: auto 110px 100px 90px 100px 100px 100px 100px 100px 100px 100px 100px;
        grid-template-columns: auto 110px 100px 90px 100px 100px 100px 100px 100px 100px 100px 100px;
        margin-top: -35px;
        padding-left: 45px;
    }

    .tree_part_main_li {
        margin-top: 20px;
    }

    .tree_part_main_li .bstree-chevron {
        width: 200px;
    }

    .tree_part_li .bstree-chevron {
        width: 100px;
    }
</style>
@endsection
@section('content')
<section class="w-full p-3 md:p-8 mx-auto max-w-[1400px]">
    <div class="flex items-center w-full gap-1 mb-4">
        <div class="w-2 h-2 min-w-2 min-h-2 mr-2 rounded-full bg-yellow-600"></div>
        <h3 class="text-base opacity-75 leading-none">Genealogy</h3>
    </div>
    <div class="p-4 rounded-xl mx-auto border border-[#1d2753] bg-[#101735] relative w-full h-full overflow-auto">
        <div id="mytree" class="bstree maintreebox">
            <ul>
                <li class="tree_head bstree-node bstree-leaf ">
                    <div class="tree_name">I'd</div>
                    <div class="tree_rang">Rank</div>
                    <div class="tree_rang">Level</div>
                    <div class="tree_rang">Date of Activation</div>
                    <div class="tree_rang">Total Team</div>
                    <div class="tree_rang">Total Directs</div>
                    <div class="tree_rang">Total Team Investment</div>
                    <div class="tree_rang">Direct Team Investment</div>
                    <div class="tree_usd">Self Investment</div>
                    <div class="tree_usd">Ads View</div>
                    <div class="tree_usd">Ads Income</div>
                    <div class="tree_usd">Your Level Income</div>
                </li>
            </ul>
            <ul>
                @if(isset($data['data']))
                @foreach($data['data'] as $key => $value)
                <li class="tree_part_main_li bstree-node bstree-composite bstree-expanded" data-id="" data-level="1">
                    @if(isset($value[$value['refferal_code']]))
                    @if(count($value[$value['refferal_code']]) > 0)
                    <div class="bstree-inner-container" onclick="getNextLeg('{{$value['refferal_code']}}', this, 1)">

                        <label class="bstree-label-container">
                            <span class="bstree-icon"></span>
                            <span class="bstree-label">
                                <span class="label label-default"></span>
                            </span>
                        </label>
                    </div>
                    @else
                    <div class="bstree-inner-container"><label class="bstree-label-container"></label></div>
                    @endif
                    @else
                    <div class="bstree-inner-container"><label class="bstree-label-container"></label></div>
                    @endif
                    <div class="tree_part_line_main">
                        <div class="tree_name_main">
                            <img src="{{ asset('assets/images/logoface.webp') }}" class="object-contain" alt="">
                            {{$value['refferal_code']}}
                        </div>
                        @if($value['rank'] == '*')
                        <div class="tree_rang"><span class="text-lg">&#10026;</span></div>
                        @else
                        <div class="tree_rang">{{$value['rank'] != '' ? $value['rank'] : 'No Rank'}}</div>
                        @endif
                        <div class="tree_rang">1</div>
                        <div class="tree_rang">{{$value['currentPackageDate'] != '-' ? date('d-m-Y', strtotime($value['currentPackageDate'])) : "-"}}</div>
                        <div class="tree_rang">{{$value['my_team']}}</div>
                        <div class="tree_rang">{{$value['my_direct']}}</div>
                        <div class="tree_rang">${{number_format($value['team_investment'],2)}}</div>
                        <div class="tree_rang">${{number_format($value['direct_investment'],2)}}</div>
                        <div class="tree_usd">${{number_format($value['totalInvestment'], 2)}}</div>
                        <div class="tree_usd">{{$value['ad_viewed']}}</div>
                        <div class="tree_usd">{{(($value['totalInvestment'] * ($value['ad_viewed'] * 0.25)) / 100)}}</div>
                        <div class="tree_usd">{{((($value['totalInvestment'] * ($value['ad_viewed'] * 0.25)) / 100) * 10 / 100)}}</div>
                    </div>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
</section>
@endsection

@section('script')

<script src={{asset('assets/js/listree.umd.min.js')}}></script>
<script type="text/javascript">
    // listree();
    $('document').ready(function() {
        $('#mytree').bstree({
            updateNodeTitle: function(node, title) {
                return '<span class="label label-default">' + node.attr('data-id') + '</span> ' + title
            }
        })
    })
    // Define a flag to keep track of expanded nodes
    const expandedNodes = {};

    function getNextLeg(x, element, level) {
        const closestLi = element.closest('.tree_part_main_li');

        closestLi.classList.remove('bstree-expanded');
        closestLi.classList.add('bstree-closed');

        closestLi.querySelectorAll('.bstree-children').forEach(childNode => {
            // childNode.style.display = 'none';
            if (childNode.style.display === 'block') {
                childNode.style.display = 'none';
            } else {
                childNode.style.display = 'block';
            }
        });

        const chevronElements = element.querySelectorAll('.bstree-chevron');

        let title;
        chevronElements.forEach((chevronElement, i) => {
            title = chevronElement.getAttribute('title');
            // console.log(chevronElement.innerHTML);
            if (closestLi.getAttribute('data-level') > 1) {
                if (chevronElement.innerHTML == '<div class="tree_plus_minus">-</div>&nbsp;') {
                    chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                } else {
                    chevronElement.innerHTML = '<div class="tree_plus_minus">-</div>&nbsp;';
                }
            } else {
                if (chevronElement.innerHTML == '<div class="tree_plus_minus">-</div>&nbsp;') {
                    chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                } else {
                    chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                }
            }
        });

        if (title == "Close") {
            const apiUrl = "{{route('fgenealogy')}}";
            const params = {
                refferal_code: x,
                type: 'API'
            };

            level = level + 1;

            // Check if the node has already been expanded
            if (!expandedNodes[x]) {
                // Mark the node as expanded
                expandedNodes[x] = true;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


                // Make a POST request to the API
                fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(params),
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the API response data as needed
                        if (data['data'].length > 0) {
                            let htmlNextLeg = '';
                            for (let i = 0; i < data['data'].length; i++) {
                                let displayRank = data['data'][i]['rank'] != null ? data['data'][i]['rank'] : 'No Rank';
                                htmlNextLeg += `<ul style="display:block" id="mytreeTwo" class="bstree-children">
                                              <i class="bstree-vline" data-vitems="9"></i>
                                              <li class="tree_part_main_li bstree-node bstree-composite bstree-expanded" data-id="" data-level="` + level + `">`;

                                if (data['data'][i][data['data'][i]['refferal_code']] !== undefined) {
                                    if (data['data'][i][data['data'][i]['refferal_code']].length > 0) {
                                        htmlNextLeg += `<div class="bstree-inner-container" onclick="getNextLeg('` + data['data'][i]['refferal_code'] + `', this, ` + level + `)">
                                                    <span class="bstree-chevron" title="Close"><div class="tree_plus_minus">+</div>&nbsp;</span>
                                                    <label class="bstree-label-container">
                                                        <span class="bstree-icon"></span>
                                                        <span class="bstree-icon"></span>
                                                        <span class="bstree-label">
                                                        <span class="label label-default"></span>
                                                        </span>
                                                    </label>
                                                 </div>`;
                                    } else {
                                        htmlNextLeg += `<div class="bstree-inner-container"><label class="bstree-label-container"></label></div>`;
                                    }
                                } else {
                                    htmlNextLeg += `<div class="bstree-inner-container"><label class="bstree-label-container"></label></div>`;
                                }

                                htmlNextLeg += `<div class="tree_part_line_main">
                                                <div class="tree_name_main">
                                                   <img src="{{ asset('assets/images/logoface.webp') }}" class="object-contain" alt="">
                                                   ` + data['data'][i]['refferal_code'] + `
                                                </div>
                                                <div class="tree_rang">` + displayRank + `</div>
                                                <div class="tree_rang">` + level + `</div>
                                                <div class="tree_rang">` + data['data'][i]['currentPackageDate'] + `</div>
                                                <div class="tree_rang">` + data['data'][i]['my_team'] + `</div>
                                                <div class="tree_rang">` + data['data'][i]['my_direct'] + `</div>
                                                <div class="tree_rang">$` + parseFloat(data['data'][i]['team_investment']).toFixed(2) + `</div>
                                                <div class="tree_rang">$` + parseFloat(data['data'][i]['direct_investment']).toFixed(2) + `</div>
                                                <div class="tree_usd">$` + parseFloat(data['data'][i]['totalInvestment']).toFixed(2) + `</div>
                                                <div class="tree_usd">` + parseInt(data['data'][i]['ad_viewed']) + `</div>
                                                <div class="tree_usd">` + parseFloat((data['data'][i]['totalInvestment'] * (data['data'][i]['ad_viewed'] * 0.25)) / 100) + `</div>
                                                <div class="tree_usd">` + parseFloat((((data['data'][i]['totalInvestment'] * (data['data'][i]['ad_viewed'] * 0.25)) / 100) * 10) / 100) + `</div>
                                             </div>
                                          </li>
                                       </ul>`
                            }
                            const parentElement = element.parentElement;
                            parentElement.insertAdjacentHTML('beforeend', htmlNextLeg);

                            chevronElements.forEach((chevronElement, i) => {
                                title = chevronElement.getAttribute('title');
                                // console.log(chevronElement.innerHTML);
                                if (closestLi.getAttribute('data-level') == 1) {
                                    if (chevronElement.innerHTML == '<div class="tree_plus_minus">-</div>&nbsp;') {
                                        chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                                    } else {
                                        chevronElement.innerHTML = '<div class="tree_plus_minus">-</div>&nbsp;';
                                    }
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    }
</script>
@endsection