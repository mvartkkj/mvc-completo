 
 
CREATE TABLE `produtos` (
  `cod_produto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome_produto` varchar(100) NOT NULL,
  `descricao_produto` varchar(200) NOT NULL
);

INSERT INTO `produtos` (`nome_produto`, `descricao_produto`) VALUES
('Hambúrguer Clássico', 'Pão, carne bovina, alface, tomate, queijo e molho especial'),
('X-Salada', 'Pão, carne bovina, alface, tomate, queijo, presunto e maionese caseira'),
('Cheeseburger', 'Pão, carne bovina e uma generosa camada de queijo derretido'),
('Combo Hamburguer com Batata', 'Hambúrguer clássico acompanhado de batata frita e refrigerante'),
('Batata Frita Média', 'Porção de batata frita crocante, temperada com sal'),
('Coxinha de Frango', 'Coxinha de frango desfiado, com massa crocante e recheio cremoso'),
('Pastel de Carne', 'Pastel crocante recheado com carne moída temperada'),
('Suco de Laranja Natural', 'Suco fresco de laranja, servido gelado'),
('Refrigerante Lata', 'Refrigerante de 350ml, várias opções de sabor'),
('Milkshake de Chocolate', 'Milkshake cremoso de chocolate com chantilly'),
('Açaí na Tigela', 'Açaí batido com banana e granola'),
('Sanduíche Natural', 'Pão integral, peito de peru, alface, tomate e requeijão light'),
('Hot Dog Completo', 'Pão, salsicha, purê de batata, milho, ervilha, batata palha e ketchup'),
('Pizza de Calabresa', 'Mini pizza de calabresa com molho de tomate e queijo derretido'),
('Tapioca de Frango com Catupiry', 'Tapioca recheada com frango desfiado e catupiry'),
('Quibe Frito', 'Quibe crocante recheado com carne temperada'),
('Pão de Queijo', 'Porção de pão de queijo quentinho e macio'),
('Café Expresso', 'Café expresso forte, servido quente'),
('Salada de Frutas', 'Porção de frutas frescas da estação, cortadas em cubos'),
('Torta de Limão', 'Torta de limão com massa crocante e cobertura de merengue');
