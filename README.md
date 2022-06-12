# Api para controle de pátios e containers

## Regras gerais:

Essa aplicação deve usar o sistema internacional de unidades. (https://pt.wikipedia.org/wiki/Sistema_Internacional_de_Unidades)

## Papéis de usuários
1.  Gerente de Imóveis
2.  Gerente de Logística
3.  Operador de Logística
      
## Pátios

Cada galpão deve possuir os seguintes atributos no banco de dados

-   Id    
-   Localizador (único e formado por 3 letras)
-   Comprimento (em cm)    
-   Largura (em cm)
    
E os seguintes atributos calculados

-   Área (m<sup>2</sup>)

Além disso ele deve obedecer os seguintes padrões:
  
1.  Possui formato cúbico  
2.  Apenas usuários com o papel gerente de imóveis podem gerenciar pátios
3.  Pátios podem ser listados, cadastrados, editados e excluídos
4.  Apenas pátios vazios podem ser excluídos
5.  O pátio não pode ter a área diminuída
6.  A área mínima do pátio é a de um container padrão
7.  Os pátios podem armazenar contêineres de acordo com a área máxima sem limite de peso total.

## Containers

Cada contêiner deve possuir os seguintes atributos

-   Localizador (Único e formado por uma letra maiúscula e 2 dígitos, exemplo: X34)    
-   Profundidade (cm)
-   Comprimento (cm)
-   Largura (cm)
-   Peso da Tara (kg)
-   Peso máximo de armazenamento (kg)
-   Pátio de armazenamento

E os seguintes atributos calculados

-   Volume (m<sup>3</sup>)    
-   Peso Bruto (Peso da tara + peso dos objetos) (tonelada)
-   Volume livre (m<sup>3</sup>)
-   Volume preenchido (m<sup>3</sup>)

Além disso eles devem obedecer às seguintes normas:

1.  Todo container nessa aplicação deverá ter as medidas pré-definidas como na imagem abaixo:

![](https://lh4.googleusercontent.com/ISWW7au9J00pKDRCy0qE0h6nmBRCkUJJd9XFauIyl4nP977RrojNoeSpQ9m317i78m7m6jC_8mDfO69lfZ6N2qoDg-4FUXXo5rvILRpXTyjOY31-eN1yjnyw1N9GwgH1byiJoMI5LeiNwJARKQ)

2.  Apenas usuários com o papel gerente de logística podem gerenciar containers
3.  Containers podem ser cadastrados, inativados e ativados.
4.  Apenas containers vazios podem ser inativados
5.  Os containers podem armazenar objetos de acordo com a área e volume máximos
6.  Cada container pode armazenar no máximo 18 toneladas (fora as 2.44 toneladas de tara)
7.  Os containers podem ser empilhados desde que a quantidade empilhada não ultrapasse 9 containers.

## Objetos

Os objetos devem possuir os seguintes atributos:
-   Identificador (GUID)
-   Profundidade (em cm)
-   Comprimento (em cm)
-   Largura (em cm)
-   Peso (em gramas)
-   Container de armazenamento

E os seguintes atributos calculados
- Volume (m<sup>3</sup>)

Além disso eles devem obedecer às seguintes normas:
1.  Todo objeto tem formato cúbico
2.  Qualquer usuário autenticado pode gerenciar objetos
3.  Objetos podem ser cadastrados e excluídos (soft delete)
4.  Os objetos podem ser empilhados livremente