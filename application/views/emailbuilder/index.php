<!DOCTYPE html>
<html>
    <head>
        <title>Email Builder</title>

        <link href="<?php echo base_url('public/emailbuilder/mosaico-material.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('public/emailbuilder/vendor/notoregular/stylesheet.css'); ?>" rel="stylesheet">

        <style>
            body {
                font-family: "trebuchet ms",arial,sans-serif;
                font-size: 13.6px;
            }
            a, a:link, a:visited {
                color: #A00000;
                text-decoration: none;
            }
            .template {
                margin: 10px;
                display: inline-block;
                vertical-align: top;
            }
            .template a {
                display: block;
                outline: 2px solid #333332;
                padding: 2px;
                width: 340px;
                height: 500px;
                overflow-y: auto;
            }
            .template a:hover {
                outline: 5px solid #900000;
                transition: outline .2s;
            }
            #savedTable tbody tr:nth-child(odd) td {
                background-color: white;
            }
            #savedTable td {
                padding: 2px 5px ;
            }
            .operationButton, .resumeButton {
                background-color: #333332;
                color: white !important;
                padding: 5px 8px;
                border-radius: 5px;
                display: inline-block;
            }
            .operationButton i {
                color: white;
            }
        </style>

        <script src="<?php echo base_url('public/emailbuilder/vendor/knockout.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.min.js'); ?>"></script>

        <script>
            var initialEdits = [];

            if (localStorage.getItem("edits")) {
                var editKeys = JSON.parse(localStorage.getItem("edits"));
                var md;
                for (var i = 0; i < editKeys.length; i++) {
                    md = localStorage.getItem("metadata-" + editKeys[i]);
                    if (typeof md === "string") {
                        initialEdits.push(JSON.parse(md));
                    }
                }

                initialEdits.sort(function (a, b) {
                    var lastA = a.changed ? a.changed : a.created;
                    var lastB = b.changed ? b.changed : b.created;
                    if (lastA < lastB) return 1;
                    if (lastA > lastB) return -1;
                    return 0;
                });
            }

            var viewModel = {
                showSaved: ko.observable(false),
                edits: ko.observableArray(initialEdits),
                templates: [
                    {name: "versatile", desc: "The versatile template"}
                ]
            };

            viewModel.edits.subscribe(function (newEdits) {
                var keys = [];
                for (var i = 0; i < newEdits.length; i++) {
                    keys.push(newEdits[i].key);
                    localStorage.setItem("metadata-" + newEdits[i].key, ko.toJSON(newEdits[i]));
                }
                localStorage.setItem("edits", ko.toJSON(keys));
            });

            viewModel.dateFormat = function (unixdate) {
                if (typeof unixdate === "undefined") return "DD-MM-YYYY";
                var d = new Date();
                d.setTime(ko.utils.unwrapObservable(unixdate));
                var m = "" + (d.getMonth()+1);
                var h = "" + (d.getHours());
                var i = "" + (d.getMinutes());
                return d.getDate() +
                    "/" +
                    (m.length == 1 ? "0" : "") +
                    m +
                    "/" +
                    d.getFullYear() +
                    " " +
                    (h.length == 1 ? "0" : "") +
                    h +
                    ":" +
                    (i.length == 1 ? "0" : "") +
                    i;
            };

            viewModel.newEdit = function (shorttmplname) {
                var d = new Date();
                var rnd = Math.random().toString(36).substr(2, 7);
                var template = shorttmplname + ".php";
                viewModel.edits.unshift({ created: Date.now(), key: rnd, name: shorttmplname, template: template });
                document.location = "<?php echo site_url(); ?>/emailbuilder/" + shorttmplname + "/#" + rnd;
            };

            viewModel.deleteEdit = function (index) {
                var confirm = window.confirm("Are you sure you want to delete this content?");
                if (confirm) {
                    var res = viewModel.edits.splice(index, 1);
                    localStorage.removeItem("template-" + res[0].key);
                }
                return false;
            };

            viewModel.list = function (clean) {
                for (var i = localStorage.length - 1; i >= 0; i--) {
                    var key = localStorage.key(i);
                    if (clean) {
                        localStorage.removeItem(key);
                    }
                }
            };

            document.addEventListener("DOMContentLoaded", function () {
                ko.applyBindings(viewModel);
            });
        </script>
    </head>

    <body style="overflow: auto; text-align: center; background-color: #3f3d33; padding: 50px 0 0 0; margin: 0; display: none;" data-bind="visible: true">
        <!-- ko if: edits().length -->
            <div style="overflow-y: auto; max-height: 200px; z-index: 10; position: relative; padding: 1em; background-color: #f1eee6;">
                <!-- ko ifnot: $root.showSaved -->
                    <span>You have saved contents in this browser!
                        <a class="resumeButton" href="#" data-bind="click: $root.showSaved.bind(undefined, true);"><i class="fa fa-plus-square"></i> Show</a>
                    </span>
                <!-- /ko -->

                <!-- ko if: $root.showSaved -->
                    <table id="savedTable" align="center" cellspacing="0" cellpadding="8" style="padding: 5px;">
                        <caption>Email contents saved in your browser
                            <a href="#" class="resumeButton" data-bind="click: $root.showSaved.bind(undefined, false);"><i class="fa fa-minus-square"></i> Hide</a>
                        </caption>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Last changed</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: edits">
                            <tr>
                                <td align="left"><a href="#" data-bind="attr: { href: '<?php echo site_url(); ?>/emailbuilder/'+name+'/#'+key }"><code>#<span data-bind="text: key">key</span></code></a></td>
                                <td style="font-weight: bold" align="left"><a href="#" data-bind="attr: { href: '<?php echo site_url(); ?>/emailbuilder/'+name+'/#'+key }"><span data-bind="text: name">versamix</span></a></td>
                                <td><span data-bind="text: typeof created !== 'undefined' ? $root.dateFormat(created) : '-'">YYYY-MM-DD</span></td>
                                <td><span style="font-weight: bold" data-bind="text: typeof changed !== 'undefined' ? $root.dateFormat(changed) : '-'">YYYY-MM-DD</span></td>
                                <td>
                                    <a class="operationButton" href="#" data-bind="click: $root.deleteEdit.bind(undefined, $index())" title="delete"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <!-- /ko -->
            </div>
        <!-- /ko -->

        <div class="content" style="background-color: white; padding-top: 15px; padding-bottom: 2em;">
            <div data-bind="foreach: templates">
                <div class="template template-xx" data-bind="attr: { class: 'template template-'+name }">
                    <div class="description" style="padding-bottom:5px"><b data-bind="text: name">xx</b>: <span data-bind="text: desc">xx</span></div>
                    <a href="#" data-bind="click: $root.newEdit.bind(undefined, name)">
                        <img src width="100%" alt="xx" data-bind="attr: { src: '<?php echo base_url(); ?>public/emailbuilder/'+name+'/edres/_full.png' }">
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
