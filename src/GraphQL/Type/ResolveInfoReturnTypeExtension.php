<?php

declare(strict_types=1);

namespace PHPStan\GraphQL\Type;

use GraphQL\Type\Definition\ResolveInfo;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\LNumber;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final class ResolveInfoReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return ResolveInfo::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getFieldSelection';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ) : Type {
        $returnTypes = [];

        /** @var ArrayType $returnType */
        $returnType = ParametersAcceptorSelector::selectFromArgs(
            $scope,
            $methodCall->args,
            $methodReflection->getVariants()
        )->getReturnType();

        $recursedType = $returnType;

        $keyType = new StringType();

        $value = $methodCall->args[0]->value;
        if ($value instanceof LNumber) {
            $i = $value->value;
            while ($i >= 0) {
                $returnTypes[] = $recursedType;

                $i--;
                $recursedType = new ArrayType($keyType, $recursedType);
            }
        }

        return TypeCombinator::union(...$returnTypes);
    }
}
