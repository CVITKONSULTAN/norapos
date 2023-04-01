function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

class BinaryFlow extends Drawflow {
    spacing_y = 30;
    spacing_x = 40;
    subnodes_spacing_y = 15
    distanceToDisconnect = 0;
    distanceToConnect = 100;
    idsRelations = {};
    nodeTypes = { "start": [0, 1], "middle": [1, 2], "condition": [1, 2], "end": [1, 0], }

    constructor(...args) {
        super(...args);
        this.on('moduleChanged', this.onModuleChanged.bind(this));

        this.on('connectionRemoved', this.onConnectionRemoved.bind(this));
        this.on('connectionCreated', this.onConnectionCreated.bind(this));

        this.on('connectionRemoved', this.updateAllFlows.bind(this));
        this.on('connectionCreated', this.updateAllFlows.bind(this));

        this.indicator = document.createElement('div');
        this.indicator.classList.add('indicator', 'invisible');
    }

    getThisIdByNodeId(id) {
        return this.getNodeFromId(id).data.node.this_node_unique_id
    }

    getIdByThisId(id) {
        return this.idsRelations[this.module][id];
    }

    addNode({ name, type, pos: { x, y }, data }) {
        if (!name) {
            console.error(name)
        }
        name = name || 'default';
        const html = this.createNodeHtml({ id: this.nodeId, data });
        const newNodeId = super.addNode(name, ...this.nodeTypes[type], x, y, type, data, html);
        this.idsRelations[this.module][data.node.this_node_unique_id] = newNodeId;
        return newNodeId;
    }

    addNewNode({ pos, node }) {
        const { name, flow_node_type_id } = node;
        const types = Object.keys(this.nodeTypes);
        const reducer = (a, b) => Math.max(a, b.data.node.this_node_unique_id);
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
        node.this_node_unique_id = allNodes.reduce(reducer, 0) + 1;
        node.prev_node_unique_id = 0;
        node.next_node_unique_id = 0;
        node.node_attributes = node.node_attributes || [];
        const type = types[flow_node_type_id % types.length];

        const newNodeId = this.addNode({
            name,
            type,
            pos,
            data: { node, subVisible: true },
        });

        // check for sub nodes:
        const { node_attributes } = node;
        if (node_attributes?.length) {
            let lastSubnodeId = this.addNewNode({ pos, node: node_attributes[0] });
            this.addConnection(newNodeId, lastSubnodeId, 'output_2', 'input_1');
            const subIds = [lastSubnodeId];
            node_attributes.slice(1).forEach(subnode => {
                const subnodeId = this.addNewNode({ pos, node: subnode });
                this.addConnection(lastSubnodeId, subnodeId, 'output_1', 'input_1');
                lastSubnodeId = subnodeId;
                subIds.push(this.getThisIdByNodeId(lastSubnodeId));
            });
            this.getNodeRef(newNodeId).data.node.node_attributes = subIds;
            this.updateAllFlows();
        }

        return newNodeId;
    }


    load() {
        super.load();
        this.updateAllFlows();
    }

    centerFlow() {
        const allFlows = this.findAllFlows();
        if (allFlows.length === 1) {
            const { height, width } = this.precanvas.getBoundingClientRect();
            const flowHeadId = allFlows[0];
            this.updateNode(flowHeadId, { pos_x: width / 3, pos_y: height / 3 });
            this.updateAllFlows();
        }
    }

    getSubHeadId(id) {
        while (this.nodeIsSub(id)) {
            id = this.nodeParentId(id);
        }
        return id;
    }

    onModuleChanged() {
        setTimeout(() => this.updateAllFlows(), 0)
    }

    onConnectionRemoved({ output_id, input_id, output_class, input_class }) {
        if (this.activeFlow && this.nodeIsSub(input_id)) {
            console.log({ output_id, input_id })
            const { ids } = this.flowLine(input_id);
            ids.forEach(id => {
                this.nodeHtmlElem(id).classList.remove('sub');
            });

            const headNodeId = this.getSubHeadId(output_id);
            const { node } = this.drawflow.drawflow[this.module].data[headNodeId].data;

            const thisIds = ids.map(this.getThisIdByNodeId.bind(this));
            thisIds.forEach(id => {
                node.node_attributes.pop(parseInt(id));
            });

        }

    }

    nodeFirstSubnodeId(id) {
        if (!this.nodeIsMiddle) return null;

        const { outputs: { output_2: { connections } } } = this.getNodeFromId(id);
        return connections[0]?.node || null;
    }

    nodeSubIds(id) {
        const firstSubnodeId = this.nodeFirstSubnodeId(id);
        return firstSubnodeId && this.flowLine(firstSubnodeId).ids;
    }

    connectSubnodesToParent() {
        this.activeFlow = false;
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data)
            .filter(({ id }) => this.nodeIsMiddle(id));

        allNodes.forEach(({ id, data: { node: { node_attributes } } }) => {
            if (!node_attributes?.length) return


            const subnodesIds = node_attributes.map(this.getIdByThisId.bind(this));
            const firstSubnodeId = subnodesIds[0];
            const lastSubnodeId = subnodesIds[subnodesIds.length - 1];

            // disconnect simple and connect original complex node to next node
            this.removeSingleConnection(id, firstSubnodeId, 'output_1', 'input_1');
            const nextNodeId = this.nodeFirstOutputId(lastSubnodeId);
            if (nextNodeId) {
                this.removeSingleConnection(lastSubnodeId, nextNodeId, 'output_1', 'input_1');
                this.addConnection(id, nextNodeId, 'output_1', 'input_1');
            }
            // connect subnodesFlow to original complex node
            this.attachSimpleFlow({ nodeInId: firstSubnodeId, nodeOutId: id, output_class: 'output_2' });
        });
        this.activeFlow = true;
    }

    connectSubnodesToFlow() { }

    allNodes(ref = false) {
        const allNodes = this.drawflow.drawflow[this.module].data;
        return ref ? allNodes : JSON.parse(JSON.stringify(allNodes))
    }

    getNodeRef(id) {
        return this.allNodes(true)[id];
    }

    nodeHasSubnodes(id) {
        return (this.nodeIsMiddle(id) && this.nodeFirstSubnodeId(id));
    }

    updateNode(id, info = {}, render = false) {
        const currentInfo = this.getNodeFromId(id);
        this.drawflow.drawflow[this.module].data[id] = _.merge(currentInfo, info);
        if (render) {
            this.renderNode(id);
        }
    }



    renderNode(id) {
        const { data: { subVisible, node: { name, description, icon_link_selected, this_node_unique_id, node_attributes }, number }, pos_x, pos_y } = this.getNodeFromId(id);
        const nodeHtml = this.nodeHtmlElem(id);
        nodeHtml.querySelector('.blockyleft img').src = icon_link_selected;
        nodeHtml.querySelector('.blockyname').innerText = name;
        nodeHtml.querySelector('.blockyinfo').innerText = description;
        nodeHtml.querySelector('.node-num').innerText = `#${number} : ${this_node_unique_id}`;

        const hasSubs = this.nodeHasSubnodes(id);

        nodeHtml.querySelector('.count-subnodes').style.display = hasSubs ? 'grid' : 'none';

        nodeHtml.style.left = pos_x + 'px'
        nodeHtml.style.top = pos_y + 'px'
        this.drawflow.drawflow[this.module].data[id].html = nodeHtml.querySelector('.drawflow_content_node').innerHTML;
        this.updateConnectionNodes(`node-${id}`);

        if (hasSubs) {
            const subIds = this.nodeSubIds(id);
            subIds.forEach(subId => {
                this.nodeHtmlElem(subId).style.display = subVisible ? 'flex' : 'none';
                document.querySelectorAll(`.connection.node_in_node-${subId}, .connection.node_out_node-${subId}`)
                    .forEach(conn => {
                        conn.style.display = subVisible ? 'inline' : 'none';
                    })
            });
            nodeHtml.querySelector('.count-subnodes').innerText = subIds.length;
            this.getNodeRef(id).data.node.node_attributes = subIds;
        }
    }

    createNodeHtml({ id, data: { node: { name, description, number, icon_link_selected } } }) {
        let html = `
<div class="blockelem create-flowy noselect">
    <div class='blockyleft noselect'>
        <img class='noselect' draggable='false' src='${icon_link_selected}'>
        <p class='blockyname noselect'>${name}</p>
    </div>
    <div class='blockyright'>
        <img src='/assets/more.svg'>
    </div>
    <div class='blockydiv'></div>
    <div class='blockyinfo noselect'>${description}</div>
</div>
<span class="node-num noselect">${number ?? 0} : ${id}</span>
<span class="count-subnodes"></span>`;
        return html;
    }

    flowLine(id) {
        // flow is line if just connected nodes without splitting(e. g. without condition)
        // returns array of nodeIds if flow is line, else, - null

        const ids = [];
        let hasSubnodes;

        while (id && !this.nodeIsCondition(id)) {
            ids.push(parseInt(id));
            hasSubnodes ||= this.nodeHasSubnodes(id);
            id = this.nodeFirstOutputId(id)
        }

        return (id !== null) ? null : { ids, hasSubnodes };
    }

    nodeFirstOutputId(id) {
        return this.getNodeFromId(id).outputs.output_1?.connections[0]?.node || null;
    }

    findAllFlows() {
        const allNodes = this.drawflow.drawflow[this.module].data;
        const flows = [];
        for (const nodeId in allNodes) {
            if (!this.nodeParentId(nodeId)) {
                flows.push(nodeId);
            }
        }
        return flows;
    }

    nodeAllOutConnections(nodeId) {
        const { outputs } = this.getNodeFromId(nodeId);
        const children = [];
        Object.values(outputs).forEach(output => {
            if (output.connections.length)
                children.push(output.connections[0]);
        });
        return children;
    }

    setLaneNumbers() {
        const allFlows = this.findAllFlows();
        let laneNodes = allFlows.map(id => ({ id, flow: id }));
        let laneNumber = 0;
        while (laneNodes.length > 0) {
            const nextLaneNodes = [];
            for (const { id, flow } of laneNodes) {
                this.updateNode(id, { data: { laneNumber, flow } });
                nextLaneNodes.push(...this.nodeAllOutConnections(id).map(conn => ({ id: conn.node, flow })));
            }
            ++laneNumber;
            laneNodes = nextLaneNodes;
        }


        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);

        allNodes.forEach(({ id, data: { laneNumber } }) => {
            if (this.nodeHasSubnodes(id)) {
                this.updateNode(id, { data: { laneNumber, laneNumberPrev: laneNumber } })

                const subIds = this.nodeSubIds(id);
                subIds.forEach(subId => {
                    this.updateNode(subId, { data: { laneNumber, laneNumberPrev: this.getNodeFromId(subId).data.laneNumber } })
                })
            }
        })
    }

    updateAllFlows() {
        this.addClassToSubnodes()

        this.setLaneNumbers();
        const allFlows = this.findAllFlows();
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);

        allFlows.forEach(flow => {
            const flowNodes = allNodes.filter(node => node.data.flow === flow);
            let number = 0;
            let laneNumber = 0;
            const compareFn = (a, b) => {
                if (a.data.laneNumberPrev !== undefined && b.data.laneNumberPrev !== undefined) {
                    return a.data.laneNumberPrev - b.data.laneNumberPrev
                }
                return 0;
            }
            let laneNodes = flowNodes.filter(node => node.data.laneNumber === laneNumber)

            while (laneNodes.length > 0) {
                laneNodes.sort(compareFn).forEach(node => {
                    this.updateNode(node.id, { data: { number: number++ } })
                });
                laneNumber++;
                laneNodes = flowNodes.filter(node => node.data.laneNumber === laneNumber);
            }
        });
        // align all flows
        allFlows.forEach(flow => {
            this.elemFlowHeight(flow);
            this.align(flow);
        });
        this.renderNodes();

        // color condition connection
        document.querySelectorAll('svg.connection').forEach(svg => {
            const nodeOutId = svg.classList[2].slice(14);
            if (this.nodeIsCondition(nodeOutId)) {
                svg.classList.add('out-condition-connection');
            };
        });

    }

    renderNodes() {
        const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
        allNodes.forEach(({ id }) => this.renderNode(id));
    }

    addClassToSubnodes() {
        const allNodes = this.allNodes(true);

        for (const id in allNodes) {
            if (this.nodeHasSubnodes(id)) {
                const subIds = this.nodeSubIds(id)
                this.nodeSubIds(id).forEach(subId => {
                    this.nodeHtmlElem(subId).classList.add('sub');
                })
                allNodes[id].data.node.node_attributes = subIds;
            }
        }
    }

    // override
    key(e) {
        super.key(e);
        if (this.editor_mode === 'fixed') {
            return false;
        }
        if (this.first_click?.tagName !== 'INPUT' && this.first_click.tagName !== 'TEXTAREA' && this.first_click.hasAttribute('contenteditable') !== true) {
            if (e.ctrlKey && e.key === 'c') {
                if (this.node_selected !== null) {
                    this.nodeToCopyStringified = JSON.stringify(this.getNodeFromId(this.node_selected.id.slice(5)));
                }
            }
            if (e.ctrlKey && e.key === 'v') {
                if (this.nodeToCopyStringified) {
                    // get mouse position
                    if (this.x && this.y) {
                        // insert node
                        const { data: { node } } = JSON.parse(this.nodeToCopyStringified);
                        // console.log(node);
                        console.log(this.addNewNode({ pos: { x: this.x, y: this.y }, node }));
                        // console.log(this.x, this.y);
                    }
                    // this.nodeToCopyStringified = null;
                }
            }

        }

    }

    nodeParentId(nodeId) {
        return this.getNodeFromId(nodeId)?.inputs?.input_1?.connections[0]?.node;
    }

    getHeadOfFlow(nodeId) {
        let parent = this.nodeParentId(nodeId);
        while (parent) {
            nodeId = parent;
            parent = this.nodeParentId(nodeId);
        }
        return nodeId;
    }

    nodeHtmlElem(nodeId) {
        return document.getElementById(`node-${nodeId}`);
    }

    nodeHasOneDirectChild(nodeId) {
        return !this.nodeIsCondition(nodeId) && this.getNodeFromId(nodeId).outputs?.output_1?.connections?.[0]?.node;
    }

    nodeIsMiddle(nodeId) {
        return this.getNodeFromId(nodeId).class === 'middle';
    }

    nodeIsCondition(nodeId) {
        return this.getNodeFromId(nodeId).class === 'condition';
    }

    nodeIsComplex(nodeId) {
        return this.getNodeFromId(nodeId).class === 'complex';
    }

    nodeIsSub(nodeId) {
        return this.nodeHtmlElem(nodeId).classList.contains('sub');
    }

    nodeIsEnd(nodeId) {
        return Object.keys(this.getNodeFromId(nodeId).outputs).length === 0;
    }

    nodeCheckClass({ nodeId, className }) {
        return this.getNodeFromId(nodeId).class === className;
    }

    alignComplexNode(id) {
        // find max width
        const complexNode = this.getNodeFromId(id);
        let { offsetWidth, offsetHeight } = this.nodeHtmlElem(id);
        let { pos_x, pos_y } = complexNode;
        let tempId = complexNode.outputs.output_2.connections?.[0]?.node;

        while (tempId) {
            pos_y += this.subnodes_spacing_y * 2 + offsetHeight;
            const { offsetWidth: width, offsetHeight: height } = this.nodeHtmlElem(tempId);
            offsetHeight = height;
            this.updateNode(tempId, { pos_x: (pos_x + offsetWidth / 2 - width / 2), pos_y });
            tempId = this.nodeAllOutConnections(tempId)?.[0]?.node;
        }
        // x = pos_x + Parentwidth/2 - inhWidth/2
    }



    align(nodeId) {
        // return 0;
        let parent = this.nodeParentId(nodeId);
        while (parent && !this.nodeIsCondition(parent)) {
            nodeId = parent;
            parent = this.nodeParentId(nodeId);
        }

        const simpleFlow = [nodeId];
        let nodeIdTmp = nodeId;
        let pos_x, pos_y;

        while (this.nodeHasOneDirectChild(nodeIdTmp) && this.nodeAllOutConnections(nodeIdTmp).length) {
            nodeIdTmp = this.getNodeFromId(nodeIdTmp).outputs.output_1.connections[0].node;
            simpleFlow.push(nodeIdTmp);
        }

        if (!this.nodeParentId(nodeId)) {
            pos_x = this.getNodeFromId(nodeId).pos_x;
            pos_y = this.getNodeFromId(nodeId).pos_y + this.nodeHtmlElem(nodeId).offsetHeight / 2;
        } else {
            // has parent that is condition
            pos_x = this.getNodeFromId(this.nodeParentId(nodeId)).pos_x + this.nodeHtmlElem(this.nodeParentId(nodeId)).offsetWidth + this.spacing_x;
            pos_y = this.getNodeFromId(this.nodeParentId(nodeId)).pos_y + this.nodeHtmlElem(this.nodeParentId(nodeId)).offsetHeight / 2;
            if (this.nodeIsCondition(nodeIdTmp)) {
                // console.log(this.getNodeFromId(nodeIdTmp).data.flowHeight, this.nodeHtmlElem(nodeIdTmp).offsetHeight);
                if (this.getNodeFromId(nodeId).inputs.input_1.connections[0].input === 'output_2') {
                    pos_y += this.spacing_y / 2 + (this.getNodeFromId(nodeIdTmp).outputs.output_1.connections.length ? this.getNodeFromId(this.getNodeFromId(nodeIdTmp).outputs.output_1.connections[0].node).data.flowHeight + this.spacing_y / 2 : this.getNodeFromId(nodeIdTmp).data.simpleFlowHeight / 2);
                } else {
                    pos_y -= this.spacing_y / 2 + (this.getNodeFromId(nodeIdTmp).outputs.output_2.connections.length ? this.getNodeFromId(this.getNodeFromId(nodeIdTmp).outputs.output_2.connections[0].node).data.flowHeight + this.spacing_y / 2 : this.getNodeFromId(nodeIdTmp).data.simpleFlowHeight / 2);
                }
            } else {
                // is last in simple flow
                const dY = this.spacing_y / 2 + this.getNodeFromId(nodeIdTmp).data.flowHeight / 2;
                const isBottom = this.getNodeFromId(nodeId).inputs.input_1.connections[0].input === 'output_2';
                pos_y += isBottom ? dY : -dY;
            }
        }

        simpleFlow.forEach(flowElemId => {
            this.updateNode(flowElemId, { pos_x, pos_y: (pos_y - this.nodeHtmlElem(flowElemId).offsetHeight / 2) });
            pos_x += this.spacing_x + this.nodeHtmlElem(flowElemId).offsetWidth;

            if (this.nodeIsMiddle(flowElemId)) {
                this.alignComplexNode(flowElemId);
            }
        });

        if (this.nodeIsCondition(nodeIdTmp)) {
            this.nodeAllOutConnections(nodeIdTmp).forEach(conn => this.align(conn.node));
        }
    }

    elemFlowHeight(nodeId) {
        let parent = this.nodeParentId(nodeId);
        while (parent && !this.nodeIsCondition(parent)) {
            nodeId = parent;
            parent = this.nodeParentId(nodeId);
        }

        let nodeIdTmp = nodeId;
        const simpleFlow = [nodeIdTmp];
        let maxHeight = this.nodeHtmlElem(nodeIdTmp).offsetHeight;
        let simpleFlowHeight = maxHeight;
        while (this.nodeHasOneDirectChild(nodeIdTmp) && this.nodeAllOutConnections(nodeIdTmp).length) {
            nodeIdTmp = this.getNodeFromId(nodeIdTmp).outputs.output_1.connections[0].node;
            simpleFlow.push(nodeIdTmp);
            maxHeight = Math.max(maxHeight, document.getElementById(`node-${nodeIdTmp}`).offsetHeight);
        }
        if (this.nodeIsCondition(nodeIdTmp)) {
            const { outputs } = this.getNodeFromId(nodeIdTmp);
            let up = outputs.output_1.connections;
            let down = outputs.output_2.connections;
            up = up.length && (this.elemFlowHeight(up[0].node) + this.spacing_y / 2);
            down = down.length && (this.elemFlowHeight(down[0].node) + this.spacing_y / 2);
            up = Math.max(up, maxHeight / 2);
            down = Math.max(down, maxHeight / 2);
            maxHeight = Math.max(maxHeight, up + down);
        }
        simpleFlow.forEach((flowElemId) => {
            this.updateNode(flowElemId, { data: { flowHeight: maxHeight, simpleFlowHeight } });
        });
        return maxHeight;
    }

    // override
    click(e) {
        super.click(e);

        // Remember starting place of element whe drag begins
        // (for nodes which can be detached if draggad away from their place)
        if (this?.ele_selected?.classList[0] === 'drawflow-node') {
            const node = this.ele_selected;
            const node_id = node.id.slice(5);
            const node_info = this.getNodeFromId(node_id);

            if (node_info.inputs?.input_1?.connections.length) {
                const { left, top } = this.ele_selected.getBoundingClientRect();
                this.startPos = { left, top };
            }
        }
    }

    // override
    position(e) {
        super.position(e);
        if (e.type === "touchmove") {
            var e_pos_x = e.touches[0].clientX;
            var e_pos_y = e.touches[0].clientY;
        } else {
            var e_pos_x = e.clientX;
            var e_pos_y = e.clientY;
        }
        this.x = e_pos_x * (this.precanvas.clientWidth / (this.precanvas.clientWidth * this.zoom)) - (this.precanvas.getBoundingClientRect().x * (this.precanvas.clientWidth / (this.precanvas.clientWidth * this.zoom)));
        this.y = e_pos_y * (this.precanvas.clientHeight / (this.precanvas.clientHeight * this.zoom)) - (this.precanvas.getBoundingClientRect().y * (this.precanvas.clientHeight / (this.precanvas.clientHeight * this.zoom)));
        if (this.drag) {
            // check 
            const node = this.ele_selected;
            const node_id = node.id.slice(5);
            const node_info = this.getNodeFromId(node_id);
            const { outputs, inputs } = node_info;
            let numInputConnections;
            if (Object.keys(inputs).length)
                numInputConnections = inputs.input_1.connections.length;
            else numInputConnections = 0;
            let numOutputConnections = 0;
            Object.values(outputs).forEach(output => numOutputConnections += output.connections.length);

            if (numInputConnections) {
                // TODO - done: Check length from previous position and if longer than some val, then - disconnect
                const { left, top } = node.getBoundingClientRect();
                const distance = Math.hypot(left - this.startPos.left, top - this.startPos.top);
                // console.log(distance);
                if (distance > this.distanceToDisconnect) {
                    const in_conn = node_info.inputs.input_1.connections[0];
                    this.removeSingleConnection(in_conn.node, node_id, in_conn.input, 'input_1');
                }
            } else if (!numInputConnections && 'input_1' in node_info.inputs) {
                const nodeInputElem = document.getElementById(`node-${node_id}`).querySelector('.input_1');
                const allNodes = Object.values(this.drawflow.drawflow[this.module].data);
                const otherNodes = allNodes.filter(node => node.data.flow !== node_id);
                // console.log(otherNodes);
                // get outputs of these nodes

                const { top, left } = nodeInputElem.getBoundingClientRect();
                let outputs = [].concat(...otherNodes.map(node => [...document.getElementById(`node-${node.id}`).querySelectorAll('.output')]));
                outputs = outputs.map(output => {
                    const pos = output.getBoundingClientRect();
                    const distance = Math.hypot(left - pos.left, top - pos.top);
                    return { output, distance };
                });
                outputs.sort((a, b) => (a.distance - b.distance));
                if (outputs.length) {
                    const nearestOutput = outputs[0].output;
                    if (outputs[0].distance < this.distanceToConnect) {
                        if (!nearestOutput.firstChild) {
                            this.indicator.parentNode?.removeChild(this.indicator);
                            nearestOutput.appendChild(this.indicator);
                        }
                        this.indicator.classList.remove('invisible');
                        const output_class = nearestOutput.classList[1];
                        this.attachTo = { output_class, nodeOutId: nearestOutput.closest('.drawflow-node').id.slice(5) };
                    } else {
                        this.indicator.classList.add('invisible');
                        this.attachTo = false;
                    }
                }
            }
        }
    }

    // addConnection(...args) {
    //     if (this.allowConnection(...args)) {
    //         super.addConnection(...args)
    //     } else {
    //         console.error('conn not allowed')
    //     }
    // }

    onConnectionCreated(info) {
        const { output_id, input_id, output_class, input_class } = info;
        // restrict
        const countOutputConnections = this.getNodeFromId(output_id).outputs[output_class].connections.length;
        const countInputConnections = this.getNodeFromId(input_id).inputs[input_class].connections.length;
        // console.log(countOutputConnections, countInputConnections);
        if (countInputConnections > 1 || countOutputConnections > 1) {
            this.removeSingleConnection(...Object.values(info));
            console.log('Restricted conn creation')
        }
    }

    nodeFlowId(id) {
        return this.getNodeFromId(id).data.flow;
    }

    attachSimpleFlow({ nodeInId, nodeOutId, output_class }) {
        const flowLine = this.flowLine(nodeInId);

        const isComlex = (this.nodeIsMiddle(nodeOutId) && output_class === 'output_2');
        if (this.nodeIsSub(nodeOutId) || isComlex) {
            if (!flowLine || flowLine.hasSubnodes) {
                return false;
            }
            if (isComlex && this.activeFlow && this.nodeHasSubnodes(nodeOutId)) {
                const { data: { subVisible } } = this.getNodeFromId(nodeOutId);
                if (!subVisible) {
                    const subIds = this.nodeSubIds(nodeOutId);
                    nodeOutId = subIds[subIds.length - 1];
                    output_class = 'output_1';
                }
            }

        }

        const { connections } = this.getNodeFromId(nodeOutId).outputs[output_class];

        if (connections.length) {
            const nextId = connections[0].node;
            if (!flowLine) {
                return false;
            }
            const { ids } = flowLine;
            const lastFlowLineNodeId = ids[ids.length - 1];
            if (this.nodeIsEnd(lastFlowLineNodeId)) {
                return false;
            }
            this.removeSingleConnection(nodeOutId, nextId, output_class, "input_1");
            this.addConnection(lastFlowLineNodeId, nextId, "output_1", "input_1");
        }

        this.addConnection(nodeOutId, nodeInId, output_class, "input_1");

        return true;
    }

    // override
    dragEnd(e) {
        const drag = this.drag;
        const node = this.ele_selected;
        super.dragEnd(e);
        // if was dragging an element

        if (drag && node) {
            const nodeInId = node.id.slice(5);
            if (this.attachTo) {
                const { nodeOutId, output_class } = this.attachTo;
                this.attachSimpleFlow({ nodeInId, nodeOutId, output_class });
                this.attachTo = false;
                this.indicator.classList.add('invisible');
            }
            this.updateAllFlows();
        }
    }

}
