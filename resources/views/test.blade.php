<style>
    svg {
        font: 10px sans-serif;
    }

    .linage {
        fill: none;
        stroke: #000;
    }

    .marriage {
        fill: none;
        stroke: black;
    }

    .man {
        background-color: lightblue;
        border-style: solid;
        border-width: 1px;
    }

    .woman {
        background-color: pink;
        border-style: solid;
        border-width: 1px;
    }

    .emphasis {
        font-style: italic;
    }

    p {
        padding: 0;
        margin: 0;
    }

    .node-template {
        width: 150px;
        height: 150px;
        border: 1px solid rgb(181, 181, 181);
        background: rgb(237, 96, 96);
    }
</style>

<div id="graph"></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/d3-dtree@2.4.1/dist/dTree.min.js"></script>
<script>
    treeData = [{
        id : 1,
        "name": "Niclas Superlongsurname",
        "class": "man",
        "textClass": "emphasis",
        "marriages": [
            {
                "spouse": {
                    "name": "Iliana",
                    "class": "woman",
                    "extra": {
                        "nickname": "Illi"
                    }
                },
                "children": [{
                    "name": "James",
                    "class": "man",
                    "marriages": [{
                        "spouse": {
                            "name": "Alexandra",
                            "class": "woman"
                        },
                        "children": [{
                            "name": "Eric",
                            "class": "man",
                            "marriages": [{
                                "spouse": {
                                    "name": "Eva",
                                    "class": "woman"
                                }
                            }]
                        }, {
                            "name": "Jane",
                            "class": "woman"
                        }, {
                            "name": "Jasper",
                            "class": "man"
                        }, {
                            "name": "Emma",
                            "class": "woman"
                        }, {
                            "name": "Julia",
                            "class": "woman"
                        }, {
                            "name": "Jessica",
                            "class": "woman"
                        }]
                    }]
                }]
            },
        ]
    }];

    treeData1 = [{
        "id": 1,
        "name": "Trần Văn A",
        "parent_marriage_id": null,
        "main_person_id": null,
        "class": "node-template",
        "marriages": [
            {
                "main_person_id": 1,
                "spouse_id": 2,
                "parent_marriage_id": null,
                "class": "node-template",
                "children": [
                    {
                        "id": 4,
                        "name": "Trần Thị AA",
                        "parent_marriage_id": 1,
                        "main_person_id": null,
                        "marriages": [],
                        "class": "node-template",
                    }
                ],
                "spouse": {
                    "id": 2,
                    "name": "Trần Thị A",
                    "parent_marriage_id": null,
                    "main_person_id": 1,
                    "class": "node-template",
                }
            },
            {
                "main_person_id": 1,
                "spouse_id": 3,
                "parent_marriage_id": null,
                "children": [],
                "spouse": {
                    "id": 3,
                    "name": "Lê Thị A",
                    "parent_marriage_id": null,
                    "main_person_id": 1,
                    "class": "node-template",
                }
            }
        ]
    }];

    const tree = dTree.init(treeData1, {
        target: "#graph",
        debug: true,
        height: 800,
        width: 1200,
        callbacks: {
            nodeClick: function(name, extra, id) {
                console.log(this);
                let x = parseInt(this.attributes.x.value) + 50;
                let y = parseInt(this.attributes.y.value) + 250;
                tree.zoomTo(x, y, 1);
            },
            nodeRightClick: function(name, extra, id) {
                console.log(id);
            },
            textRenderer: function(name, extra, textClass) {
                if (extra && extra.nickname)
                    name = name + " (" + extra.nickname + ")";
                return "<p align='center' class='" + textClass + "'>" + name + "</p>";
            },
            nodeRenderer: function(name, x, y, height, width, extra, id, nodeClass, textClass, textRenderer) {
                console.log(extra);
                let node = '';
                node += '<div ';
                node += 'data-id="" ';
                node += 'style="height:100%;width:100%;" ';
                node += 'class="' + nodeClass + '" ';
                node += 'id="node' + id + '">\n';
                node += textRenderer(name, extra, textClass);
                node += `<img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg">`;
                node += '</div>';
                return node;
            }
        },
    });
    treeData2 = [{
        "id": 1,
        "name": "Trần Văn AAAAAA",
        "parent_marriage_id": null,
        "main_person_id": null,
        "class": "node-template",
        "marriages": [
            {
                "main_person_id": 1,
                "spouse_id": 2,
                "parent_marriage_id": null,
                "class": "node-template",
                "children": [
                    {
                        "id": 4,
                        "name": "Trần Thị AA",
                        "parent_marriage_id": 1,
                        "main_person_id": null,
                        "marriages": [],
                        "class": "node-template",
                    }
                ],
                "spouse": {
                    "id": 2,
                    "name": "Trần Thị A",
                    "parent_marriage_id": null,
                    "main_person_id": 1,
                    "class": "node-template",
                }
            },
            {
                "main_person_id": 1,
                "spouse_id": 3,
                "parent_marriage_id": null,
                "children": [],
                "spouse": {
                    "id": 3,
                    "name": "Lê Thị A",
                    "parent_marriage_id": null,
                    "main_person_id": 1,
                    "class": "node-template",
                }
            }
        ]
    }];
    $(window).click(function(){
        // $('#graph').empty();
        // dTree.init(treeData2, {
        //     target: "#graph",
        //     debug: true,
        //     height: 800,
        //     width: 1200,
        //     callbacks: {
        //         nodeClick: function(name, extra) {
        //             console.log(name);
        //         },
        //         textRenderer: function(name, extra, textClass) {
        //             if (extra && extra.nickname)
        //                 name = name + " (" + extra.nickname + ")";
        //             return "<p align='center' class='" + textClass + "'>" + name + "</p>";
        //         },
        //         nodeRenderer: function(name, x, y, height, width, extra, id, nodeClass, textClass, textRenderer) {
        //             console.log(extra);
        //             let node = '';
        //             node += '<div ';
        //             node += 'data-id="" ';
        //             node += 'style="height:100%;width:100%;" ';
        //             node += 'class="' + nodeClass + '" ';
        //             node += 'id="node' + id + '">\n';
        //             node += textRenderer(name, extra, textClass);
        //             node += `<img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg">`;
        //             node += '</div>';
        //             return node;
        //         }
        //     }
        // });
        // tree.zoomToNode(7);

        // appendChild(treeData, 1, {test: '123'});
        // console.log(treeData);
    });
    


    // Append data
    function appendChild(treeData, parentId, childData)
    {
        let find = findNestedObj(treeData, "id", parentId);
        console.log(find);
        if (find) {
            find.marriages[0].children = childData;
        }
    }

    function findNestedObj(entireObj, keyToFind, valToFind)
    {
        let foundObj;
        JSON.stringify(entireObj, (_, nestedValue) => {
            if (nestedValue && nestedValue[keyToFind] === valToFind) {
                foundObj = nestedValue;
            }
            return nestedValue;
        });
        return foundObj;
    };

    appendChild(treeData, 1, [
        {
            "id" : 123123,
            "name " : "test11111111111"
        }
    ]);

    console.log(treeData);
</script>
